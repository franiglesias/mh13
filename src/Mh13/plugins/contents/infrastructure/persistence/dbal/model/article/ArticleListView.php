<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 16:20
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\model\article;


use Mh13\plugins\contents\infrastructure\persistence\dbal\model\ViewModel;


class ArticleListView extends ViewModel
{
    protected $id;
    protected $title;
    protected $content;
    protected $slug;
    protected $pubDate;
    protected $expiration;
    protected $featured;
    protected $stick;
    protected $image;
    protected $blog_slug;
    protected $blog_title;

    /**
     * @return mixed
     */
    public function getBlogTitle()
    {
        return $this->blog_title;
    }

    /**
     * @param mixed $blog_title
     */
    public function setBlogTitle($blog_title)
    {
        $this->blog_title = $blog_title;
    }

    /**
     * @return mixed
     */
    public function getBlogSlug()
    {
        return $this->blog_slug;
    }

    /**
     * @param mixed $blog_slug
     */
    public function setBlogSlug($blog_slug)
    {
        $this->blog_slug = $blog_slug;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @param mixed $pubDate
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param mixed $expiration
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    /**
     * @return mixed
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * @param mixed $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * @return mixed
     */
    public function getStick()
    {
        return $this->stick;
    }

    /**
     * @param mixed $stick
     */
    public function setStick($stick)
    {
        $this->stick = $stick;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


}
