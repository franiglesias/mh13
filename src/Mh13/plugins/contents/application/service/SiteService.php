<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\readmodel\SiteReadModel;


class SiteService
{
    /**
     * @var SiteReadModel
     */
    private $readModel;

    /**
     * SiteService constructor.
     */
    public function __construct(SiteReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function getSiteWithSlug(string $site)
    {
        return $this->readModel->getWithSlug($site);
    }

    public function getBlogs(string $site)
    {
        return $this->readModel->getBlogs($site);
    }
}
