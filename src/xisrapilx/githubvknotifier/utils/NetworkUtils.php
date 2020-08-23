<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\utils;

use xisrapilx\githubvknotifier\utils\exception\NetworkUtilsException;

final class NetworkUtils{

    private function __construct(){
        // NOOP
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param array $curlOptions
     * @param string $agent
     * @return string
     * @throws NetworkUtilsException
     */
    public static function postRequest(string $url, array $params = [], array $headers = [], array $curlOptions = [], string $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)") : string{
        $ch = curl_init();

        if($curlOptions !== null)
            curl_setopt_array($ch, $curlOptions);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if(!$result){
            throw new NetworkUtilsException(curl_error($ch), curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param array $curlOptions
     * @param string $agent
     * @return string
     * @throws NetworkUtilsException
     */
    public static function getRequest(string $url, array $params = [], array $headers = [], array $curlOptions = [], string $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)") : string{
        $ch = curl_init();

        if(!empty($curlOptions))
            curl_setopt_array($ch, $curlOptions);

        if(!empty($params)){
            $url .= "?".http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $url);
        curl_setopt($ch, CURLOPT_URL, $url);

        if(!empty($headers))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $errorNumber = curl_errno($ch);
        if($errorNumber !== 0){
            throw new NetworkUtilsException(curl_error($ch), $errorNumber);
        }

        curl_close($ch);

        return $result;
    }
}