<?php

namespace Mh13\plugins\contents\application\service\catalog;

use Mh13\plugins\contents\exceptions\InvalidSite;
use Symfony\Component\Yaml\Yaml;


/**
 * Class SiteService
 *
 * Provides the list of configured blogs for a given site
 *
 * Sites must be configured under the sites key at config.yml
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
class SiteService
{
    private $file;
    private $sites;

    /**
     * SiteService constructor.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->sites = null;
    }

    /**
     * @param string $site
     *
     * @return array with blog slugs
     */
    public function getBlogs(string $site): array
    {
        $this->load();
        $this->isValidSite($site);

        return $this->sites[$site];
    }

    /**
     * lazy loads the data from config file
     */
    private function load()
    {
        if ($this->sites) {
            return;
        }
        $data = Yaml::parse(file_get_contents($this->file));
        $this->sites = $data['sites'];
    }

    /**
     * @param $site
     *
     * @throws InvalidSite
     */
    private function isValidSite($site)
    {
        if (!isset($this->sites[$site])) {
            throw InvalidSite::withName($site);
        }
    }
}
