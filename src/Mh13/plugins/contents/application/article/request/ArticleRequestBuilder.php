<?php

namespace Mh13\plugins\contents\application\article\request;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\ParameterBag;


/**
 * Class CatalogRequestBuilder
 *
 * Data neede to make a request to the catalog service
 *
 * @package Mh13\plugins\contents\application\service\catalog
 */
class ArticleRequestBuilder
{
    const LIMIT = 15;

    private $blogs = [];
    private $excludeBlogs = [];

    // Not implemented yet

    private $labels = [];

    // pagination

    private $page = 1;
    private $limit = self::LIMIT;

    // restrictions

    private $home = false;
    private $featured = false;
    private $public = true;
    private $ignoreSticky = false;


    /**
     * ArticleRequestBuilder constructor.
     *
     * @param CommandBus $bus
     */
    public function __construct()
    {
    }

    public static function fromQuery(ParameterBag $query)
    {
        $builder = new ArticleRequestBuilder();

        return $builder->withQuery($query);
    }

    public function withQuery(ParameterBag $query)
    {
        if ($query->has('blogs')) {
            $this->fromBlogs(...$query->get('blogs'));
        }
        if ($query->has('excludeBlogs')) {
            $this->excludeBlogs(...$query->get('excludeBlogs'));
        }

        if ($query->getBoolean('featured', false)) {
            $this->onlyFeatured();
        }
        if ($query->getBoolean('home', false)) {
            $this->onlyHome();
        }
        if (!$query->getBoolean('public', true)) {
            $this->allowPrivate();
        }
        if ($query->has('page')) {
            $this->page($query->getInt('page'));
        }

        return $this;
    }

    /**
     * @return ArticleRequestBuilder
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

    public function ignoreSticky()
    {
        $this->ignoreSticky = true;

        return $this;
    }

    public function buildFromQueryData(ParameterBag $query)
    {
        return $this->withQuery($query)->getRequest();
    }

    public function getRequest(): ArticleRequest
    {
        $request = new ArticleRequest();
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
