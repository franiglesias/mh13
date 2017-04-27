<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:05
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog;


use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class BlogIsActive extends CompositeDbalSpecification
{

    public function getConditions()
    {
        return 'blog.active = 1';
    }
}
