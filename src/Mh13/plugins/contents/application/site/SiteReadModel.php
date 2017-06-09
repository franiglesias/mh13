<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 11:18
 */

namespace Mh13\plugins\contents\application\site;


/**
 * Class FSSiteReadModel
 *
 * Provides the list of configured blogs for a given site
 *
 * Sites must be configured under the sites key at config.yml
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
interface SiteReadModel
{
    /**
     * @param string $site
     *
     * @return array with blog slugs
     */
    public function getBlogs(string $site): array;

    public function getWithSlug(string $site): array;
}
