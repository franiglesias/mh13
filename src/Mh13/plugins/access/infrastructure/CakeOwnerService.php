<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 10:04
 */

namespace Mh13\plugins\access\infrastructure;


use Mh13\plugins\access\services\Owned;
use Mh13\plugins\access\services\Owner;
use Mh13\plugins\access\services\OwnerService;
use Mh13\plugins\access\services\Permissions;
use Mh13\plugins\access\exceptions\OwnershipException;


class CakeOwnerService implements OwnerService
{
    private $ownerService;

    /**
     * CakeOwnerService constructor.
     *
     * @param $ownerService
     */
    public function __construct($ownerService)
    {
        $this->ownerService = $ownerService;
    }


    /**
     * @param       $model
     * @param       $ownerModel
     * @param array $extra
     *
     * @return mixed
     */
    public function owners($model, $ownerModel, $extra = [])
    {
        return $this->ownerService->owners($model, $ownerModel, $extra);
    }

    /**
     * @param Owned       $object
     * @param Owner       $owner
     * @param Permissions $permissions
     *
     * @return mixed
     */
    public function addOwner(Owned $object, Owner $owner, Permissions $permissions)
    {
        try {
            $this->ownerService->addOwner($object, $owner, $permissions->getPermission());
        } catch (\Exception $exception) {
            throw OwnershipException::message($exception->getMessage());
        }

    }

}
