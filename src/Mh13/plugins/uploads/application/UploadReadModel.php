<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:03
 */

namespace Mh13\plugins\uploads\application;


interface UploadReadModel
{
    public function findUploads($specification, UploadContext $context);


}
