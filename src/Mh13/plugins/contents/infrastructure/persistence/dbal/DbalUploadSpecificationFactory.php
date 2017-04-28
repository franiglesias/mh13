<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\upload\AttachedFilesContext;
use Mh13\plugins\contents\domain\UploadSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\AttachedDownloads;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\AttachedImages;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\AttachedMedia;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\DownloadsOfArticle;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfArticle;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfCollection;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfStaticPage;


class DbalUploadSpecificationFactory implements UploadSpecificationFactory
{
    protected $expressionBuilder;


    public function __construct(Connection $connection)
    {
        $this->expressionBuilder = $connection->getExpressionBuilder();
    }

    public function createAttachedImages(AttachedFilesContext $context, string $slug)
    {
        return new AttachedImages($this->expressionBuilder, $context, $slug);
    }

    public function createAttachedDownloads(AttachedFilesContext $context, string $slug)
    {
        return new AttachedDownloads($this->expressionBuilder, $context, $slug);
    }

    public function createAttachedMedia(AttachedFilesContext $context, string $slug)
    {
        return new AttachedMedia($this->expressionBuilder, $context, $slug);
    }
}
