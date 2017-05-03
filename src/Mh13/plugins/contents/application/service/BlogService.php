<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:39
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\BlogReadModel;
use Mh13\plugins\contents\domain\BlogSpecificationFactory;


class BlogService
{
    /**
     * @var BlogReadModel
     */
    private $readmodel;
    /**
     * @var BlogSpecificationFactory
     */
    private $specificationFactory;

    public function __construct(BlogReadModel $readmodel, BlogSpecificationFactory $specificationFactory)
    {

        $this->readmodel = $readmodel;
        $this->specificationFactory = $specificationFactory;
    }

    public function getBlogWithSlug(string $slug)
    {
        $specification = $this->specificationFactory->createBlogWithSlug($slug);
        $blog = $this->readmodel->getBlog($specification);

        return $blog;
    }

    public function getPublicBlogs()
    {
        $specification = $this->specificationFactory->createPublicBlogs();
        $blogs = $this->readmodel->findBlogs($specification);

        return $blogs;
    }

}
