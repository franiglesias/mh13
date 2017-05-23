<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 10:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


class GetSiblingsForPageWithSlug implements DBalStaticPageSpecification
{
    /**
     * @var QueryBuilder
     */
    private $builder;
    /**
     * @var string
     */
    private $slug;


    /**
     * GetSiblingsForPageWithSlug constructor.
     */
    public function __construct(QueryBuilder $builder, string $slug)
    {

        $this->builder = $builder;
        $this->slug = $slug;
    }

    public function getQuery(): Statement
    {
        $subQuery = clone ($this->builder);
        $subQuery->select('parent_id')->from('static_pages')->where('slug = :slug');
        $this->builder->select('page.title, page.slug')->from('static_pages', 'page')->where(
            'parent_id = ('.$subQuery->getSQL().')'
            )->andWhere('page.slug <> :slug')->setParameter('slug', $this->slug)
        ;

        return $this->builder->execute();
    }
}
