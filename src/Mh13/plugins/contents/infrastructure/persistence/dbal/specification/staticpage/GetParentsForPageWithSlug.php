<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 16:14
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


class GetParentsForPageWithSlug implements DBalStaticPageSpecification
{
    /**
     * @var QueryBuilder
     */
    private $builder;
    /**
     * @var string
     */
    private $slug;

    public function __construct(QueryBuilder $builder, string $slug)
    {

        $this->builder = $builder;
        $this->slug = $slug;
    }

    public function getQuery(): Statement
    {
        $this->builder->select('parent.title, parent.slug')->from('static_pages', 'node')->from(
                'static_pages',
                'parent'
            )->where('node.lft BETWEEN parent.lft AND parent.rght')->andWhere(
                'node.slug = ? AND parent.slug <> node.slug'
            )->setParameter(0, $this->slug)->orderBy('parent.lft', 'asc')
        ;

        return $this->builder->execute();
    }
}
