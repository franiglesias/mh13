<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:05
 */

namespace Mh13\plugins\contents\domain;


use Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContext;


interface UploadSpecificationFactory
{

    public function createAttachedImages(DBalUploadContext $context, string $slug);

    public function createAttachedDownloads(DBalUploadContext $context, string $slug);

    public function createAttachedMedia(DBalUploadContext $context, string $slug);

}
