<?php

namespace Mh13\plugins\contents\application\site;


class GetSiteWithSlugHandler
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

    public function handle(GetSiteWithSlug $getSiteWithSlug)
    {
        return $this->readModel->getWithSlug($getSiteWithSlug->getSiteName());
    }

}
