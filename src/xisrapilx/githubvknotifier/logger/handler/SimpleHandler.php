<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\logger\handler;

use Monolog\DateTimeImmutable;
use Monolog\Handler\AbstractHandler;

class SimpleHandler extends AbstractHandler{

    public function handle(array $record) : bool{
        if($record["level"] < $this->level){
            return false;
        }

        /** @var DateTimeImmutable $dateTimeImmutable */
        $dateTimeImmutable = $record["datetime"];
        echo "[{$record["channel"]}] [{$record["level_name"]}] [{$dateTimeImmutable->format("H:i:s")}] ".$record["message"].PHP_EOL;

        return true;
    }
}