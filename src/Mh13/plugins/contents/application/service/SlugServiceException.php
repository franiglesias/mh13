<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 15:12
 */

namespace Mh13\plugins\contents\application\service;


class SlugServiceException extends \Exception
{
    public static function message($message)
    {
        return new self($message);
    }
}
