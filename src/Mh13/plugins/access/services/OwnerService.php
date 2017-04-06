<?php

namespace Mh13\plugins\access\services;

interface OwnerService
{
    public function owners($model, $ownerModel, $extra = []);

    public function addOwner(Owned $object, Owner $owner, Permissions $permissions);
}
