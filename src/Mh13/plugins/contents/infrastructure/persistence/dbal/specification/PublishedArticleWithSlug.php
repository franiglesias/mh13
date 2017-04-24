<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 16:12
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Query\QueryBuilder;


class PublishedArticleWithSlug implements DBalArticleSpecification
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;
    /**
     * @var string
     */
    private $slug;

    public function __construct(QueryBuilder $queryBuilder, string $slug)
    {

        $this->queryBuilder = $queryBuilder;
        $this->slug = $slug;
    }


    /**
     * Generates a Query to retrieve the desired articles
     *
     * @return QueryBuilder
     */
    public function getQuery(): QueryBuilder
    {
        $this->queryBuilder->select('articles.*', 'blogs.slug as blog_slug', 'images.path as image')
            ->from('items', 'articles')
            ->leftJoin('articles', 'blogs', 'blogs', 'articles.channel_id = blogs.id')
            ->leftJoin('articles', 'uploads', 'images', 'images.model = "Item" and images.foreign_key = articles.id')
            ->where('articles.slug = ?')
            ->setParameter(
            0,
            $this->slug
        )
        ;

        return $this->queryBuilder;
    }
}
