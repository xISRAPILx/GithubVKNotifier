<?php

declare(strict_types=1);

namespace xisrapilx\githubvknotifier\data\github;

class Repository{

    /**
     * @var int
     */
    public $id;

    /**
     * @var User
     */
    public $owner;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $full_name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var boolean
     */
    public $private;

    /**
     * @var boolean
     */
    public $fork;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $html_url;

    /**
     * @var string
     */
    public $clone_url;

    /**
     * @var string
     */
    public $git_url;

    /**
     * @var string
     */
    public $ssh_url;

    /**
     * @var string
     */
    public $svn_url;

    /**
     * @var string
     */
    public $mirror_url;

    /**
     * @var string
     */
    public $homepage;

    /**
     * @var string
     */
    public $language;

    /**
     * @var int
     */
    public $forks;

    /**
     * @var int
     */
    public $forks_count;

    /**
     * @var int
     */
    public $watchers;

    /**
     * @var int
     */
    public $watchers_count;

    /**
     * @var int
     */
    public $size;

    /**
     * @var string
     */
    public $master_branch;

    /**
     * @var int
     */
    public $open_issues;

    /**
     * @var int
     */
    public $open_issues_count;

    /**
     * @var string
     */
    public $pushed_at;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
    
}