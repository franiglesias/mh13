<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 16:12
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;


class PublishedArticleWithSlug implements DBalArticleSpecification
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var string
     */
    private $slug;

    public function __construct(Connection $connection, string $slug)
    {

        $this->connection = $connection;
        $this->slug = $slug;
    }

    public function fetch()
    {
        $statement = $this->getQuery()->execute();

        return $statement->fetch();

    }

    /**
     * Generates a Query to retrieve the desired articles
     *
     * @return QueryBuilder
     */
    public function getQuery(): QueryBuilder
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('articles.*', 'blogs.slug as blog_slug', 'images.path as image')
            ->from('items', 'articles')
            ->leftJoin('articles', 'blogs', 'blogs', 'articles.channel_id = blogs.id')
            ->leftJoin('articles', 'uploads', 'images', 'images.model = "Item" and images.foreign_key = articles.id')
            ->where('articles.slug = ?')
            ->setParameter(
            0,
            $this->slug
        )
        ;

        return $builder;
    }
}
