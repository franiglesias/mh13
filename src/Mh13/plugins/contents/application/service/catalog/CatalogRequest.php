<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 13:35
 */

namespace Mh13\plugins\contents\application\service\catalog;


class CatalogRequest
{
    /**
     * @var bool
     */
    protected $featured;
    /**
     * @var bool
     */
    protected $public;
    /**
     * @var int
     */
    protected $page;
    /**
     * @var int
     */
    protected $max;
    protected $blogs;
    protected $excludedBlogs;
    /**
     * @var bool
     */
    private $home;

    /**
     * @return bool
     */
    public function onlyHome(): bool
    {
        return $this->home;
    }

    /**
     * @param bool $home
     */
    public function setHome(bool $home)
    {
        $this->home = $home;
    }

    public function onlyFeatured(): bool
    {
        return $this->featured;
    }

    /**
     * @param mixed $featured
     */
    public function setFeatured(bool $featured)
    {
        $this->featured = $featured;
    }

    public function onlyPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;
    }

    public function setPage($page, $max)
    {
        $this->page = $page;
        $this->max = $max;
    }

    public function from()
    {
        if (!$this->page) {
            return 0;
        }

        return (($this->page - 1) * $this->max) + 1;

    }

    public function max()
    {
        return $this->max;
    }

    public function blogs()
    {
        return $this->blogs;
    }

    /**
     * @param array $blogs
     */
    public function setBlogs($blogs)
    {
        $this->blogs = $blogs;
    }

    /**
     * @return mixed
     */
    public function excludedBlogs()
    {
        return $this->excludedBlogs;
    }

    /**
     * @param mixed $excludedBlogs
     */
    public function setExcludedBlogs($excludedBlogs)
    {
        $this->excludedBlogs = $excludedBlogs;
    }


}
