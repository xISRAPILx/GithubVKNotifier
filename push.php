<?php

/**
 * Push webhook handler
 */

declare(strict_types=1);

require_once "header.php";

use xisrapilx\githubvknotifier\data\github\hook\exception\HookException;
use xisrapilx\githubvknotifier\data\github\hook\Push;
use xisrapilx\githubvknotifier\logger\LoggerProvider;
use xisrapilx\githubvknotifier\utils\config\ConfigProvider;
use xisrapilx\githubvknotifier\utils\exception\NetworkUtilsException;
use xisrapilx\githubvknotifier\utils\NetworkUtils;
use xisrapilx\githubvknotifier\utils\vk\exception\VKException;
use xisrapilx\githubvknotifier\utils\vk\VKUtils;

$logger = LoggerProvider::provide();

try{
    $config = ConfigProvider::provide();

    if($config->testing){
        $push = Push::fromJsonObject(json_decode(file_get_contents("test.json")));
    }else{
        $push = Push::fromInput();
    }

    if(!in_array($push->repository->id, $config->acceptedRepositoryIds)){
        $logger->notice("Попытка обработки репозитория не из списка разрешенных(политкорректно!) репозиториев.");

        return;
    }

    if(empty($push->commits)){
        $logger->notice("Событие без изменений не может быть обработано.");

        return;
    }

    try{
        $artifactFilename = WORKING_DIRECTORY."artifact.zipp";

        $bytes = file_put_contents($artifactFilename, NetworkUtils::getRequest(
            "https://api.github.com/repos/{$push->repository->full_name}/zipball",
            [],
            [],
            [
                CURLOPT_USERPWD => "{$config->githubLogin}:{$config->githubAccessToken}"
            ]
        ));

        $logger->info("Ядро успешно скачано! Байтов записано: ".$bytes);

        if($bytes > 1){
            $vkUtils = new VKUtils($config->vkAccessToken, "5.122");

            try{
                $data = $vkUtils->getMessagesDocumentUploadServer($config->vkPeerId);
                if(isset($data["response"]["upload_url"])){
                    $data = $vkUtils->uploadDocument($data["response"]["upload_url"], $artifactFilename);

                    if(isset($data["file"])){
                        $data = $vkUtils->saveDocument($data);

                        if(isset($data["response"])){
                            $message = "Новые изменения в репозитории {$push->repository->full_name}!".PHP_EOL.PHP_EOL;

                            $message .= "Коммиты:";
                            foreach($push->commits as $commit){
                                $message .= $commit->message.PHP_EOL;
                            }

                            $message .= PHP_EOL."Автор изменений: ".$push->sender->login;

                            $data = $vkUtils->sendMessage(
                                $config->vkPeerId,
                                $message,
                                "doc".$data["response"]["doc"]["owner_id"]."_".$data["response"]["doc"]["id"]);

                            if(is_int($data["response"])){
                                $logger->info("Сообщение с артифактом отправлено! Идентификатор: ".$data["response"]);
                            }else{
                                $logger->error("Не получилось отправить сообщение в диалог!");
                            }
                        }else{
                            $logger->error("Не удалось сохранить документ!");
                            $logger->debug(var_export($data, true));
                        }
                    }else{
                        $logger->error("Не удалось загрузить документ!");
                        $logger->debug(var_export($data, true));
                    }
                }else{
                    $logger->error("Не удалось получить сервер для загрузки документа!");
                    $logger->debug(var_export($data, true));
                }
            }catch(VKException $exception){
                $logger->error("[{$exception->getCode()}] ".$exception->getMessage());
                $logger->debug($exception->getTraceAsString());
            }
        }else{
            $logger->info("Не удалось загрузить артифакты!");
        }
    }catch(NetworkUtilsException $exception){
        $logger->error("[{$exception->getCode()}]".$exception->getMessage());
        $logger->debug($exception->getTraceAsString());
    }
}catch(HookException $exception){
    $logger->error($exception->getMessage());
    $logger->debug($exception->getTraceAsString());
}
