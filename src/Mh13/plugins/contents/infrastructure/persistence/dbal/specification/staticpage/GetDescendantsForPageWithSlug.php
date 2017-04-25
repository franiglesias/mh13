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


class GetDescendantsForPageWithSlug implements DBalStaticPageSpecification
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

    /*
     * SELECT node.title, node.slug , count(parent.slug) - (sub_tree.depth) as depth
    FROM static_pages as node, static_pages as parent, static_pages as sub_parent, (
        SELECT node.title, node.slug , count(parent.slug) as depth
        FROM static_pages as node, static_pages as parent
        WHERE (node.lft BETWEEN parent.lft AND parent.rght) AND (node.slug = 'comunidad_educativa')
        group by node.slug
        ORDER BY node.lft asc
    ) as sub_tree
    WHERE (node.lft BETWEEN parent.lft AND parent.rght) and (node.lft between sub_parent.lft and sub_parent.rght) and (sub_parent.slug = sub_tree.slug)
    group by node.slug
    ORDER BY node.lft asc
     *
     *
     * */

    public function getQuery(): Statement
    {
        $this->builder->select('node.title, node.slug')
            ->from('static_pages', 'node')
            ->from('static_pages', 'parent')
            ->where('node.lft BETWEEN parent.lft AND parent.rght')
            ->andWhere('parent.slug = ? AND parent.slug <> node.slug')
            ->setParameter(0, $this->slug)
            ->orderBy('parent.lft', 'asc')
        ;

        return $this->builder->execute();
    }
}
