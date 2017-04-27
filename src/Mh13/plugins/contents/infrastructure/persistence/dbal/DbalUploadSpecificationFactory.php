<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\UploadSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload\ImagesOfArticle;


class DbalUploadSpecificationFactory implements UploadSpecificationFactory
{
    protected $expressionBuilder;


    public function __construct(Connection $connection)
    {
        $this->expressionBuilder = $connection->getExpressionBuilder();
    }

    public function createImagesOfArticle(string $slug)
    {
        return new ImagesOfArticle($this->expressionBuilder, $slug);
    }
}
