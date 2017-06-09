<?php

namespace Mh13\plugins\contents\application\site;


class GetListOfBlogInSiteHandler
{
    /**
     * @var \Mh13\plugins\contents\application\site\SiteReadModel
     */
    private $readModel;

    /**
     * SiteService constructor.
     */
    public function __construct(SiteReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function handle(GetListOfBlogInSite $getListOfBlogInSite)
    {
        return $this->readModel->getBlogs($getListOfBlogInSite->getSiteName());
    }
}
