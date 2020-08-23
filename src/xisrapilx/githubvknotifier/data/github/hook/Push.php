<?php
// Because phpdoc != annotations (((
/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github\hook;

class Push extends Hook{

    /** @var string */
    public $ref;

    /** @var string */
    public $before;

    /** @var \xisrapilx\githubvknotifier\data\github\Commit[] */
    public $commits = [];

    /** @var \xisrapilx\githubvknotifier\data\github\Commit */
    public $head_commit;

    /** @var \xisrapilx\githubvknotifier\data\github\Organization */
    public $organization;

    /** @var \xisrapilx\githubvknotifier\data\github\Repository */
    public $repository;

    /** @var \xisrapilx\githubvknotifier\data\github\User */
    public $sender;

    /** @var \xisrapilx\githubvknotifier\data\github\Pusher */
    public $pusher;
}