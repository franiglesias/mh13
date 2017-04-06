<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 11:00
 */

namespace Mh13\plugins\access\exceptions;


class OwnershipException extends \RuntimeException
{
    public static function message($message)
    {
        return new self($message);
    }

}
