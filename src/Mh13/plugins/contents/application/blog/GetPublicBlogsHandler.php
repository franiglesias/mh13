<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:39
 */

namespace Mh13\plugins\contents\application\blog;


use Mh13\plugins\contents\domain\BlogSpecificationFactory;


class GetPublicBlogsHandler
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

    public function handle(GetPublicBlogs $getPublicBlogs)
    {
        $specification = $this->specificationFactory->createPublicBlogs();
        $blogs = $this->readmodel->findBlogs($specification);

        return $blogs;
    }

}
