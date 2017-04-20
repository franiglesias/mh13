<?php

namespace Mh13\plugins\contents\application\service\catalog;

use Symfony\Component\Yaml\Yaml;


class SiteService
{
    private $file;
    private $data;

    public function __construct($file)
    {
        $this->file = $file;
        $this->data = null;
    }

    public function getBlogs($site)
    {
        if (!$this->data) {
            $this->load();
        }
        return $this->data['sites'][$site];
    }

    private function load()
    {
        $this->data = Yaml::parse(file_get_contents($this->file));
    }
}
