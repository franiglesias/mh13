<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:42
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;


use Doctrine\DBAL\Query\QueryBuilder;
use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\domain\Article;


class FromArticleRequest implements DbalArticleSpecification
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;
    /**
     * @var ArticleRequest
     */
    private $articleRequest;

    /**
     * FromCatalogRequest constructor.
     *
     * @param QueryBuilder   $queryBuilder
     * @param ArticleRequest $articleRequest
     */
    public function __construct(QueryBuilder $queryBuilder, ArticleRequest $articleRequest)
    {
        $this->queryBuilder = $queryBuilder;
        $this->articleRequest = $articleRequest;
    }


    public function getQuery(): QueryBuilder
    {
        $subQuery = clone $this->queryBuilder;
        $subQuery->select('uploads.id')->from('uploads')->where(
            "uploads.model = 'Item' and uploads.foreign_key = items.id"
        )->orderBy('uploads.order')->setMaxResults(1)
        ;
        $this->queryBuilder->select(
            'items.id as id',
            'items.slug as slug',
            'items.title as title',
            'items.content as content',
            'items.pubDate as pubDate',
            'items.expiration as expiration',
            'items.featured as featured',
            'items.stick as sticky',
            'blogs.slug as blog_slug',
            'blogs.title as blog_title',
            'uploads.path as image'
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
            $this->queryBuilder->expr()->eq('uploads.id', '('.$subQuery->getSQL().')')

        )->where(
            'items.status = :published and items.pubDate <= now() and (items.expiration is null or items.expiration > now() ) and blogs.active = 1'
        )->setParameter('published', Article::PUBLISHED)
        ;
        if ($this->articleRequest->blogs()) {
            $this->queryBuilder->andWhere('blogs.slug IN (:blogs)')->setParameter(
                'blogs',
                $this->articleRequest->blogs(),
                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            );
        }
        if ($this->articleRequest->excludedBlogs()) {
            $this->queryBuilder->andWhere('blogs.slug NOT IN (:excluded)')->setParameter(
                'excluded',
                $this->articleRequest->excludedBlogs(),
                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            );
        }

        if (!$this->articleRequest->ignoreSticky()) {
            $this->queryBuilder->addOrderBy('items.stick', 'desc');
        }

        $this->queryBuilder->addOrderBy('items.pubDate', 'desc');
        if ($this->articleRequest->from()) {
            $this->queryBuilder->setFirstResult($this->articleRequest->from());
        }
        if ($this->articleRequest->max()) {
            $this->queryBuilder->setMaxResults($this->articleRequest->max());
        }

        return $this->queryBuilder;
    }
}
