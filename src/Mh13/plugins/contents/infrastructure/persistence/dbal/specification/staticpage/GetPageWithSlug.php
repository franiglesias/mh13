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
        $this->builder->select('*', 'image.path as image')->from('static_pages', 'static')->leftJoin(
                'static',
                'uploads',
                'image',
                'image.id = (select uploads.id from uploads where uploads.model="StaticPage" and foreign_key = static.id order by uploads.order asc limit 1)'

            )->where('static.slug = ?')->setParameter(
            0,
            $this->slug
        )
        ;

        return $this->builder->execute();
    }
}
