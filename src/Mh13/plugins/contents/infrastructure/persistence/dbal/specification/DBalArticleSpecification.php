<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Query\QueryBuilder;


interface DBalArticleSpecification
{
    /**
     * Generates a Query to retrieve the desired articles
     *
     * @return QueryBuilder
     */
    public function getQuery(): QueryBuilder;

    public function fetch();

}
