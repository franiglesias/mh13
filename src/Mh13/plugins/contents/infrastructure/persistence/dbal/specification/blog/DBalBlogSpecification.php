<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 13:27
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog;

use Doctrine\DBAL\Driver\Statement;


interface DBalBlogSpecification
{
    public function getQuery(): Statement;
}
