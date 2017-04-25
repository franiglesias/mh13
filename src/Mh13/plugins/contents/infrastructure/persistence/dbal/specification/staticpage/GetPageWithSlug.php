<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:06
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


class GetPageWithSlug implements DBalStaticPageSpecification
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
        $this->builder->select('*')->from('static_pages', 'static')->where('static.slug = ?')->setParameter(
            0,
            $this->slug
        )
        ;

        return $this->builder->execute();
    }
}
