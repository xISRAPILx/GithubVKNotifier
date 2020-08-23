<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github\hook;

use JsonMapper;
use JsonMapper_Exception;
use xisrapilx\githubvknotifier\data\github\hook\exception\HookException;

abstract class Hook{

    /** @var JsonMapper */
    private static $jsonMapper;

    private static function getJsonMapper() : JsonMapper{
        if(self::$jsonMapper === null){
            self::$jsonMapper = new JsonMapper();
            self::$jsonMapper->bStrictNullTypes = false;
        }

        return self::$jsonMapper;
    }

    /**
     * @param object $object
     * @return static
     * @throws HookException
     */
    public static function fromJsonObject(object $object) : self{
        $self = new static();

        try{
            self::getJsonMapper()->map($object, $self);
        }catch(JsonMapper_Exception $exception){
            throw new HookException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $self;
    }

    /**
     * @return static
     * @throws HookException
     */
    public static function fromInput() : self{
        $input = file_get_contents("php://input");

        return self::fromJsonObject(json_decode($input));
    }
}