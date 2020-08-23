<?php
declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github;

class Commit{

    /** @var string */
    public $id;

    /** @var string */
    public $tree_id;

    /** @var bool */
    public $distinct;

    /** @var string */
    public $message;

    /** @var string */
    public $timestamp;

    /** @var string */
    public $url;

    /** @var Pusher */
    public $author;

    /** @var Pusher */
    public $sender;

    /** @var string[] */
    public $added;

    /** @var string[] */
    public $removed;

    /** @var string[] */
    public $modified;
}