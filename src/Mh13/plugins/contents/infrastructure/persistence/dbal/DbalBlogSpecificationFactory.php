<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 13:22
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\ActiveBlogWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\BlogIsActive;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\BlogWithSlug;


class DbalBlogSpecificationFactory implements BlogSpecificationFactory
{

    public function createBlogWithSlug(string $slug)
    {
        $blogIsActive = new BlogIsActive();

        return $blogIsActive->and(new BlogWithSlug($slug));
    }
}
