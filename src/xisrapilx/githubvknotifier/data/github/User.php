<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github;

class User{

    /** @var string */
    public $login;

    /** @var int */
    public $id;

    /** @var string */
    public $node_id;

    /** @var string */
    public $avatar_url;

    /** @var string */
    public $gravatar_id;

    /** @var string */
    public $url;

    /** @var string */
    public $html_url;

    /** @var string */
    public $followers_url;

    /** @var string */
    public $following_url;

    /** @var string */
    public $gists_url;

    /** @var string */
    public $starred_url;

    /** @var string */
    public $subscriptions_url;

    /** @var string */
    public $organizations_url;

    /** @var string */
    public $repos_url;

    /** @var string */
    public $events_url;

    /** @var string */
    public $received_events_url;

    /** @var string */
    public $type;

    /** @var bool */
    public $site_admin;
}