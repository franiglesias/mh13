<?php

namespace Mh13\plugins\contents\infrastructure\persistence\filesystem;

use Mh13\plugins\contents\application\readmodel\SiteReadModel;
use Mh13\plugins\contents\exceptions\InvalidSite;
use Symfony\Component\Yaml\Yaml;


/**
 * Class FSSiteReadModel
 *
 * Provides the list of configured blogs for a given site
 *
 * Sites must be configured under the sites key at config.yml
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
class FSSiteReadModel implements SiteReadModel
{
    private $file;
    private $sites;

    /**
     * FSSiteReadModel constructor.
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

        return $this->sites[$site]['blogs'];
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

    public function getWithSlug(string $site): array
    {
        $this->load();
        $this->isValidSite($site);

        return [
            'name' => $site,
            'title' => $this->sites[$site]['title'],
            'description' => $this->sites[$site]['description'],
        ];
    }
}
