<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 9:35
 */

namespace Mh13\plugins\access\services;


class Permissions
{
    const READ = 1;
    const WRITE = 2;
    const DELETE = 4;
    const ADMIN = 8;
    const MEMBER = 16;
    const NOT_MANAGED = 32;

    /**
     * @var integer
     */
    private $permission;

    /**
     * Permissions constructor.
     *
     * @param int $permission
     */
    public function __construct($permission)
    {
        $this->permission = $permission;
    }

    public function canRead()
    {
        return $this->permission & self::READ;
    }

    public function canWrite()
    {
        return $this->permission & self::WRITE;
    }

    public function canDelete()
    {
        return $this->permission & self::DELETE;
    }

    public function getPermission()
    {
        return $this->permission;
    }
}
