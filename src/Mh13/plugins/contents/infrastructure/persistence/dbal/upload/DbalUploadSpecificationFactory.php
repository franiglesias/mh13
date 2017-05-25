<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\upload;


use Mh13\plugins\contents\application\service\upload\UploadContext;
use Mh13\plugins\contents\domain\UploadSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\DownloadsOfArticle;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfArticle;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfCollection;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfStaticPage;
use Mh13\plugins\contents\infrastructure\persistence\dbal\upload\specification\AttachedDownloads;


class DbalUploadSpecificationFactory implements UploadSpecificationFactory
{


    public function createAttachedImages(UploadContext $context, string $slug)
    {
        return new specification\AttachedImages($context, $slug);
    }

    public function createAttachedDownloads(UploadContext $context, string $slug)
    {
        return new AttachedDownloads($context, $slug);
    }

    public function createAttachedMedia(UploadContext $context, string $slug)
    {
        return new specification\AttachedMedia($context, $slug);
    }
}
