<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Mh13\plugins\contents\application\service\ReadOnlyBlogRepository;
use Mh13\plugins\contents\domain\BlogSpecificationFactory;


class DbalReadOnlyBlogRepository implements ReadOnlyBlogRepository
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
