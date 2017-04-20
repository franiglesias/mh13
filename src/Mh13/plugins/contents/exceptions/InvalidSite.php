<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 20/4/17
 * Time: 13:21
 */

namespace Mh13\plugins\contents\exceptions;


class InvalidSite extends ContentException
{
    public static function withName($siteName)
    {
        return new static(sprintf('Site %s is not defined in config.yml or sites.yml.', $siteName));
    }
}
