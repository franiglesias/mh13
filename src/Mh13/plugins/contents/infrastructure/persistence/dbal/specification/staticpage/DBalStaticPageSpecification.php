<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 10:29
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage;


use Doctrine\DBAL\Driver\Statement;


interface DBalStaticPageSpecification
{
    public function getQuery(): Statement;
}
