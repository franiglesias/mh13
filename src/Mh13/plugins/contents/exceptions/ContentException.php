<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:00
 */

namespace Mh13\plugins\contents\exceptions;


class ContentException extends \Exception
{
    public static function message($message)
    {
        return new static($message);
    }
}
