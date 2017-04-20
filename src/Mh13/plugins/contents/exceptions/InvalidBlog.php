<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 20/4/17
 * Time: 17:20
 */

namespace Mh13\plugins\contents\exceptions;


class InvalidBlog extends ContentException
{
    public static function withSlug($slug)
    {
        return new static(sprintf('Blog with slug %s is not defined.', $slug));
    }

}
