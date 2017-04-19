<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:42
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\catalog\CatalogRequest;
use Mh13\plugins\contents\domain\Article;


class FromCatalogRequest implements DBalArticleSpecification
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var CatalogRequest
     */
    private $catalogRequest;

    /**
     * FromCatalogRequest constructor.
     */
    public function __construct(Connection $connection, CatalogRequest $catalogRequest)
    {
        $this->connection = $connection;
        $this->catalogRequest = $catalogRequest;
    }

    public function getQuery()
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('items.id', 'items.slug', 'items.title', 'items.content')->from('items')->leftJoin(
                'items',
                'blogs',
                'blogs',
                'items.channel_id = blogs.id'
            )->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('items.status', Article::PUBLISHED),
                    $queryBuilder->expr()->lte('items.pubDate', 'NOW()'),
                    $queryBuilder->expr()->orX(
                        $queryBuilder->expr()->isNull('items.expiration'),
                        $queryBuilder->expr()->gt('items.expiration', 'NOW()')
                    ),
                    $queryBuilder->expr()->eq('blogs.active', true)
                )
            )
        ;
        $queryBuilder->addOrderBy('items.pubDate', 'desc');
        if ($this->catalogRequest->from()) {
            $queryBuilder->setFirstResult($this->catalogRequest->from());
        }
        if ($this->catalogRequest->max()) {
            $queryBuilder->setMaxResults($this->catalogRequest->max());
        }

        return $queryBuilder->getSQL();
    }
}
