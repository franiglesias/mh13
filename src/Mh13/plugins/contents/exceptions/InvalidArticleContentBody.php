<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 17:18
 */

namespace Mh13\plugins\contents\exceptions;


class InvalidArticleContentBody extends \InvalidArgumentException
{
    public static function message($message)
    {
        return new self($message);
    }
}
