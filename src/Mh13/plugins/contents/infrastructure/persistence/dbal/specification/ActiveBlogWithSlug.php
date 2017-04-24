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
     * @var QueryBuilder
     */
    private $queryBuilder;
    /**
     * @var string
     */
    private $slug;

    /**
     * ActiveBlogWithSlug constructor.
     *
     * @param Connection|QueryBuilder $queryBuilder
     * @param string                  $slug
     */
    public function __construct(QueryBuilder $queryBuilder, string $slug)
    {
        $this->queryBuilder = $queryBuilder;
        $this->slug = $slug;
    }


    public function getQuery(): QueryBuilder
    {
        $this->queryBuilder->select('blogs.*')
            ->from('blogs')
            ->where('blogs.slug = ?')
            ->andWhere('blogs.active = 1')
            ->setParameter(
                0,
                $this->slug
            )
        ;

        return $this->queryBuilder;

    }
}
