<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\query\BlogWithSlug;


class BlogService
{

    /**
     * @var BlogSpecificationFactory
     */
    private $factory;

    public function __construct(BlogSpecificationFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getBlog(string $slug)
    {
        $query = $this->factory->createBlogWithSlug($slug);
        $blog = $query->fetch();

        return $blog;


    }


}
