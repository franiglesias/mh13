<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 13:22
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\blog;


use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\ActiveBlogWithSlug;


class DbalBlogSpecificationFactory implements BlogSpecificationFactory
{

    public function createBlogWithSlug(string $slug)
    {
        $blogIsActive = new specification\BlogIsActive();

        return $blogIsActive->and(new specification\BlogWithSlug($slug));
    }

    public function createBlogIsExternal()
    {
        return new specification\BlogIsExternal();
    }

    public function createBlogIsActive()
    {
        return new specification\BlogIsActive();
    }

    public function createPublicBlogs()
    {
        $blogIsActive = new specification\BlogIsActive();

        return $blogIsActive->and(new specification\BlogIsExternal());
    }
}
