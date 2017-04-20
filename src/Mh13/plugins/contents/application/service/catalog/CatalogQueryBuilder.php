<?php

namespace Mh13\plugins\contents\application\service\catalog;

use Symfony\Component\HttpFoundation\ParameterBag;


/**
 * Class CatalogQueryBuilder
 *
 * Data neede to make a request to the catalog service
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
class CatalogQueryBuilder
{
    const LIMIT = 15;

    private $blogs = [];
    private $excludeBlogs = [];
    private $labels = [];
    // pagination

    private $page;
    private $limit = self::LIMIT;
    private $offset;

    private $sticky;

    // restrictions
    private $home = false;
    private $featured = false;
    private $public = true;
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
        $builder = new CatalogQueryBuilder($siteService);
        $builder->fromBlogs(...$query->get('blogs'));
        $builder->excludeBlogs(...$query->get('excludeBlogs'));
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
     * @return CatalogQueryBuilder
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

    protected function manageCollissions()
    {
        $coincidences = array_intersect($this->blogs, $this->excludeBlogs);
        $this->blogs = array_values(array_diff($this->blogs, $this->excludeBlogs));
        $this->excludeBlogs = array_values(array_diff($this->excludeBlogs, $coincidences));
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

    public function isRestrictedToHome(): bool
    {
        return $this->home;
    }

    public function isRestrictedToFeatured(): bool
    {
        return $this->featured;
    }

    public function onlyPublic(): self
    {
        $this->public = true;

        return $this;
    }

    public function isRestrictedToPublic(): bool
    {
        return $this->public;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getBlogs()
    {
        return $this->blogs;
    }

    public function getExcludedBlogs()
    {
        return $this->excludeBlogs;
    }

    public function fromSite($site): self
    {
        $this->fromBlogs($this->siteService->getBlogs($site));
        $this->manageCollissions();

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

        return $request;
    }


}
