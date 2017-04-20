<?php

namespace Mh13\plugins\contents\application\service\catalog;

use Symfony\Component\HttpFoundation\ParameterBag;


/**
 * Class CatalogRequestBuilder
 *
 * Data neede to make a request to the catalog service
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
class CatalogRequestBuilder
{
    const LIMIT = 15;

    private $blogs = [];
    private $excludeBlogs = [];
//    private $labels = [];
    // pagination

    private $page;
    private $limit = self::LIMIT;

    // restrictions

    private $home = false;
    private $featured = false;
    private $public = true;
    private $ignoreSticky = false;

    /**
     * @var SiteService
     */
    private $siteService;

    public function __construct(SiteService $siteService)
    {

        $this->siteService = $siteService;
    }

    public static function fromQuery(ParameterBag $query, SiteService $siteService)
    {
        $builder = new CatalogRequestBuilder($siteService);
        if ($query->has('blogs')) {
            $builder->fromBlogs(...$query->get('blogs'));

        }
        if ($query->has('excludeBlogs')) {

            $builder->excludeBlogs(...$query->get('excludeBlogs'));
        }
        if ($site = $query->getAlnum('site')) {
            $builder->fromBlogs($builder->siteService->getBlogs($site));
        }
        if ($query->getBoolean('featured', false)) {
            $builder->onlyFeatured();
        }
        if ($query->getBoolean('home', false)) {
            $builder->onlyHome();
        }
        if (!$query->getBoolean('public', true)) {
            $builder->allowPrivate();
        }
        if ($query->has('page')) {
            $builder->page($query->getInt('page'));
        }


        return $builder;
    }

    /**
     * @return CatalogRequestBuilder
     */
    public function fromBlogs(): self
    {
        $arguments = func_get_args();
        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $this->fromBlogs(...$argument);
                continue;
            }
            $this->blogs[] = $argument;
        }

        $this->manageCollissions();

        return $this;
    }

    public function excludeBlogs(): self
    {
        $this->excludeBlogs = array_merge($this->excludeBlogs, func_get_args());
        $this->manageCollissions();

        return $this;

    }

    public function onlyFeatured(): self
    {
        $this->featured = true;

        return $this;
    }

    public function onlyHome(): self
    {
        $this->home = true;

        return $this;
    }

    public function allowPrivate(): self
    {
        $this->public = false;

        return $this;
    }

    public function page($page): self
    {
        $this->page = $page;

        return $this;
    }

    protected function manageCollissions()
    {
        $coincidences = array_intersect($this->blogs, $this->excludeBlogs);
        $this->blogs = array_values(array_diff($this->blogs, $this->excludeBlogs));
        $this->excludeBlogs = array_values(array_diff($this->excludeBlogs, $coincidences));
    }

    public function onlyPublic(): self
    {
        $this->public = true;

        return $this;
    }


    public function fromSite($site): self
    {
        $this->fromBlogs($this->siteService->getBlogs($site));
        $this->manageCollissions();

        return $this;
    }


    public function ignoreSticky()
    {
        $this->ignoreSticky = true;

        return $this;
    }

    public function getCatalogRequest(): CatalogRequest
    {
        $request = new CatalogRequest();
        $request->setHome($this->home);
        $request->setFeatured($this->featured);
        $request->setPublic($this->public);
        $request->setPage($this->page, $this->limit);
        $request->setBlogs($this->blogs);
        $request->setExcludedBlogs($this->excludeBlogs);
        $request->setIgnoreSticky($this->ignoreSticky);

        return $request;
    }
}