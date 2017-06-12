<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:39
 */

namespace Mh13\plugins\contents\application\blog;


use Mh13\plugins\contents\application\readmodel\BlogReadModel;
use Mh13\plugins\contents\domain\BlogSpecificationFactory;


class GetBlogByAliasHandler
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

    public function handle(GetBlogByAlias $getBlogByAlias)
    {
        $specification = $this->specificationFactory->createBlogWithSlug($getBlogByAlias->getAlias());
        $blog = $this->readmodel->getBlog($specification);

        return $blog;
    }

}
