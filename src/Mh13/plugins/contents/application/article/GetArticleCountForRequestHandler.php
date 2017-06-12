<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:14
 */

namespace Mh13\plugins\contents\application\article;


use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class GetArticleCountForRequestHandler
{

    /**
     * @var ArticleReadModel
     */
    private $readmodel;
    /**
     * @var ArticleSpecificationFactory
     */
    private $specificationFactory;


    public function __construct(
        ArticleReadModel $readmodel,
        ArticleSpecificationFactory $specificationFactory
    ) {
        $this->readmodel = $readmodel;
        $this->specificationFactory = $specificationFactory;
    }


    public function handle(GetArticleCountForRequest $getArticleCountForRequest)
    {
        $request = $getArticleCountForRequest->getRequest();
        $specification = $this->specificationFactory->createFromCatalogRequest($request);

        return $this->readmodel->ignoringStickFlag($request->ignoreSticky())->from($request->from())->max(
            $request->max()
        )->count($specification)
            ;
    }

}
