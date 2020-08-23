<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\utils\vk;

use CURLFile;
use xisrapilx\githubvknotifier\utils\exception\NetworkUtilsException;
use xisrapilx\githubvknotifier\utils\NetworkUtils;
use xisrapilx\githubvknotifier\utils\vk\exception\VKException;

class VKUtils{

    /** @var string */
    private $accessToken;

    /** @var string */
    private $version;

    public function __construct(string $accessToken, string $version = "5.122"){
        $this->accessToken = $accessToken;
        $this->version = $version;
    }

    /**
     * @param array $data
     * @throws VKException
     */
    private function processVKErrors(array $data) : void{
        if(isset($data["error"])){
            throw new VKException($data["error"]["error_msg"], intval($data["error"]["error_code"]));
        }
    }

    /**
     * @param int $peerId
     * @return array
     * @throws NetworkUtilsException
     * @throws VKException
     */
    public function getMessagesDocumentUploadServer(int $peerId) : array{
        $data = json_decode(NetworkUtils::postRequest(
            "https://api.vk.com/method/docs.getMessagesUploadServer",
            [
                "type" => "doc",
                "peer_id" => $peerId,
                "v" => "5.122",
                "access_token" => $this->accessToken
            ]), true);

        $this->processVKErrors($data);

        return $data;
    }

    /**
     * @param string $url
     * @param string $filename
     * @return array
     * @throws NetworkUtilsException
     * @throws VKException
     */
    public function uploadDocument(string $url, string $filename) : array{
        $data = json_decode(NetworkUtils::postRequest(
            $url,
            [
                "file" => new CURLFile($filename)
            ]
        ), true);

        if(isset($data["error"])){
            throw new VKException($data["error"]);
        }

        return $data;
    }

    /**
     * @param array $documentData
     * @return array
     * @throws NetworkUtilsException
     * @throws VKException
     */
    public function saveDocument(array $documentData) : array{
        $data = json_decode(NetworkUtils::postRequest(
            "https://api.vk.com/method/docs.save",
            array_merge($documentData, [
                "v" => "5.122",
                "access_token" => $this->accessToken
            ])), true);

        $this->processVKErrors($data);

        return $data;
    }

    /**
     * @param int $peerId
     * @param string $message
     * @param string $attachments
     * @return array
     * @throws NetworkUtilsException
     * @throws VKException
     */
    public function sendMessage(int $peerId, string $message, string $attachments) : array{
        $data = json_decode(NetworkUtils::postRequest("https://api.vk.com/method/messages.send", [
            "random_id" => time(),
            "peer_id" => $peerId,
            "message" => $message,
            "v" => "5.122",
            "attachment" => $attachments,
            "access_token" => $this->accessToken
        ]), true);

        $this->processVKErrors($data);

        return $data;
    }
}
