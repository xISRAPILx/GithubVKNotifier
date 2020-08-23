<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\utils\config;

class Config{

    /** @var string */
    public $vkAccessToken;

    /** @var int */
    public $vkPeerId;

    /** @var string */
    public $githubLogin;

    /** @var string */
    public $githubAccessToken;

    /** @var int[] */
    public $acceptedRepositoryIds = [];

    /** @var bool */
    public $testing = false;
}