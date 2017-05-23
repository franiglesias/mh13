<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 16:14
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


class GetDescendantsWithDepthForPageWithSlug implements DBalStaticPageSpecification
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
        $subtree = clone $this->builder;
        $subtree->select('node.title, node.slug, count(parent.slug) as depth')
            ->from('static_pages', 'node')
            ->from(
                'static_pages',
                'parent'
            )
            ->where('node.lft BETWEEN parent.lft AND parent.rght')
            ->andWhere('node.slug = ?')
            ->groupBy('node.slug')
            ->orderBy('node.lft', 'asc')
        ;

        $this->builder->select('node.title, node.slug, count(parent.slug) - (sub_tree.depth) as depth')->from(
                'static_pages',
                'node'
            )
            ->from('static_pages', 'parent')
            ->from('static_pages', 'sub_parent')
            ->from(
                '('.$subtree->getSQL().')',
                'sub_tree'
            )
            ->where('node.lft BETWEEN parent.lft AND parent.rght')
            ->andwhere(
                'node.lft BETWEEN sub_parent.lft AND sub_parent.rght'
            )
            ->andWhere('sub_parent.slug = sub_tree.slug')
            ->andWhere('node.slug <> parent.slug')
            ->groupBy('node.slug')
            ->orderBy('node.lft', 'asc')
            ->setParameter(0, $this->slug)
        ;

        return $this->builder->execute();
    }
}
