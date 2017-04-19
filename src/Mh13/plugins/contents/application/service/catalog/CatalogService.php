<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 17:01
 */

namespace Mh13\plugins\contents\application\service\catalog;


use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class CatalogService
{
    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var ArticleSpecificationFactory
     */
    private $specificationFactory;

    /**
     * CatalogService constructor.
     */
    public function __construct(ArticleRepository $repository, ArticleSpecificationFactory $specificationFactory)
    {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    public function getArticles(CatalogRequest $request)
    {
        $articles = $this->repository->findAll($this->specificationFactory->createFromCatalogRequest($request));

        return $articles;
    }
}
