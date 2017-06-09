<?php

namespace Mh13\plugins\contents\application\site;


class GetSiteWithSlug
{
    /**
     * @var string
     */
    private $siteName;

    /**
     * SiteService constructor.
     */
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;
    }

    /**
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->siteName;
    }

}
