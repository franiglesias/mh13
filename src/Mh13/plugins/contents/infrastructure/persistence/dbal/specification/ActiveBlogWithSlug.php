<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 12:44
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;


class ActiveBlogWithSlug implements DBalBlogSpecification
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var string
     */
    private $slug;

    /**
     * ActiveBlogWithSlug constructor.
     *
     * @param Connection $connection
     * @param string     $slug
     */
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

    public function getQuery(): QueryBuilder
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('blogs.*')->from('blogs')->where('blogs.slug = ?')->andWhere('blogs.active = 1')->setParameter(
                0,
                $this->slug
            )
        ;

        return $builder;

    }
}
