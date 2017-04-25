<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;


use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


interface DbalArticleSpecification
{
    /**
     * Generates a Query to retrieve the desired articles
     *
     * @return QueryBuilder
     */
    public function getQuery(): Statement;

}
