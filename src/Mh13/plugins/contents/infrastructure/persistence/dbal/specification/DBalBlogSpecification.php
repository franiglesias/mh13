<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 13:27
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;

use Doctrine\DBAL\Query\QueryBuilder;


interface DBalBlogSpecification
{
    public function getQuery(): QueryBuilder;

    public function fetch();
}
