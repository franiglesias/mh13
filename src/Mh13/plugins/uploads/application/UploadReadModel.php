<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:03
 */

namespace Mh13\plugins\uploads\application;


use Mh13\plugins\contents\application\service\upload\UploadContext;


interface UploadReadModel
{
    public function findUploads($specification, UploadContext $context);


}
