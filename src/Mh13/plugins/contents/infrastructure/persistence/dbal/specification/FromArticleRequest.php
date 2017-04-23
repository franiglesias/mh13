<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:42
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Mh13\plugins\contents\application\service\catalog\ArticleRequest;
use Mh13\plugins\contents\domain\Article;


class FromArticleRequest implements DBalArticleSpecification
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var ArticleRequest
     */
    private $catalogRequest;

    /**
     * FromCatalogRequest constructor.
     */
    public function __construct(Connection $connection, ArticleRequest $catalogRequest)
    {
        $this->connection = $connection;
        $this->catalogRequest = $catalogRequest;
    }


    public function getQuery(): QueryBuilder
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $subQuery = $this->connection->createQueryBuilder();
        $subQuery->select('uploads.id')->from('uploads')->where(
            "uploads.model = 'Item' and uploads.foreign_key = items.id"
        )->orderBy('uploads.order')->setMaxResults(1)
        ;
        $queryBuilder->select(
            'items.id as article_id',
            'items.slug as article_slug',
            'items.title as article_title',
            'items.content as article_content',
            'items.pubDate as article_pubDate',
            'items.expiration as article_expiration',
            'items.featured as article_featured',
            'items.stick as article_sticky',
            'blogs.slug as blog_slug',
            'blogs.title as blog_title',
            'uploads.path as image_path'
        )->from(
            'items'
        )->leftJoin(
            'items',
            'blogs',
            'blogs',
            'items.channel_id = blogs.id'
        )->leftJoin(
            'items',
            'uploads',
            'uploads',
            $queryBuilder->expr()->eq('uploads.id', '('.$subQuery->getSQL().')')

        )->where(
            'items.status = :published and items.pubDate <= now() and (items.expiration is null or items.expiration > now() ) and blogs.active = 1'
        )->setParameter('published', Article::PUBLISHED)
        ;
        if ($this->catalogRequest->blogs()) {
            $queryBuilder->andWhere('blogs.slug IN (:blogs)')->setParameter(
                'blogs',
                $this->catalogRequest->blogs(),
                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            );
        }
        if ($this->catalogRequest->excludedBlogs()) {
            $queryBuilder->andWhere('blogs.slug NOT IN (:excluded)')->setParameter(
                'excluded',
                $this->catalogRequest->excludedBlogs(),
                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            );
        }

        if (!$this->catalogRequest->ignoreSticky()) {
            $queryBuilder->addOrderBy('items.stick', 'desc');
        }

        $queryBuilder->addOrderBy('items.pubDate', 'desc');
        if ($this->catalogRequest->from()) {
            $queryBuilder->setFirstResult($this->catalogRequest->from());
        }
        if ($this->catalogRequest->max()) {
            $queryBuilder->setMaxResults($this->catalogRequest->max());
        }

        return $queryBuilder;
    }
}
