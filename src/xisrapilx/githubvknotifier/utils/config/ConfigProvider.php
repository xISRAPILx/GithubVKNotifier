<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\utils\config;

use JsonMapper;
use JsonMapper_Exception;
use xisrapilx\githubvknotifier\logger\LoggerProvider;

final class ConfigProvider{

    private const FILENAME = "config.json";

    private function __construct(){
    }

    public static function provide() : Config{
        $logger = LoggerProvider::provide();

        if(is_file(WORKING_DIRECTORY.self::FILENAME)){
            $jsonMapper = new JsonMapper();
            $jsonMapper->bStrictNullTypes = false;

            $config = new Config();
            try{
                $jsonMapper->map(json_decode(file_get_contents(WORKING_DIRECTORY.self::FILENAME)), $config);
            }catch(JsonMapper_Exception $exception){
                $logger->error($exception->getMessage());
                $logger->debug($exception->getTraceAsString());
                exit(1);
            }

            return $config;
        }else{
            file_put_contents(WORKING_DIRECTORY.self::FILENAME, json_encode(new Config(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            $logger->critical("Не найден конфиг! Файл был создан, заполните его.");
            exit(1);
        }
    }
}