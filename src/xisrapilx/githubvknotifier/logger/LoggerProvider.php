<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\logger;

use Psr\Log\LoggerInterface;

final class LoggerProvider{

    /** @var LoggerInterface */
    private static $logger;

    private function __construct(){
        // NOOP
    }

    public static function provide() : LoggerInterface{
        if(self::$logger === null){
            self::$logger = new BaseLogger();
        }

        return self::$logger;
    }
}