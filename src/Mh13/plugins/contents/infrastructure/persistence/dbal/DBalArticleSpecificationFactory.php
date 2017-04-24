<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\catalog\ArticleRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\FromArticleRequest;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\PublishedArticleWithSlug;


class DBalArticleSpecificationFactory implements ArticleSpecificationFactory
{
    /**
     * @var Connection
     */
    private $connection;


    /**
     * DBalArticleSpecificationFactory constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createLastArticles()
    {
        // TODO: Implement createLastArticles() method.
    }

    public function createFromCatalogRequest(ArticleRequest $catalogRequest)
    {
        return new FromArticleRequest($this->connection->createQueryBuilder(), $catalogRequest);
    }

    public function createPublishedArticleWithSlug(string $slug)
    {
        return new PublishedArticleWithSlug($this->connection->createQueryBuilder(), $slug);
    }
}
