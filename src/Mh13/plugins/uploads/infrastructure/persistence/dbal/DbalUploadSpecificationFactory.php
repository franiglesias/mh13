<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:11
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal;


use Mh13\plugins\contents\domain\UploadSpecificationFactory;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContext;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\specification\AttachedDownloads;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\specification\AttachedImages;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\specification\AttachedMedia;


class DbalUploadSpecificationFactory implements UploadSpecificationFactory
{


    public function createAttachedImages(DBalUploadContext $context, string $slug)
    {
        return new AttachedImages($context, $slug);
    }

    public function createAttachedDownloads(DBalUploadContext $context, string $slug)
    {
        return new AttachedDownloads($context, $slug);
    }

    public function createAttachedMedia(DBalUploadContext $context, string $slug)
    {
        return new AttachedMedia($context, $slug);
    }
}
