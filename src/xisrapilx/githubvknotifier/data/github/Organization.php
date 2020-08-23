<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github;

class Organization{

    /** @var string */
    public $login;

    /** @var int */
    public $id;

    /** @var string */
    public $node_id;

    /** @var string */
    public $url;

    /** @var string */
    public $repos_url;

    /** @var string */
    public $events_url;

    /** @var string */
    public $hooks_url;

    /** @var string */
    public $issues_url;

    /** @var string */
    public $members_url;

    /** @var string */
    public $public_members_url;

    /** @var string */
    public $avatar_url;

    /** @var string */
    public $description;
}