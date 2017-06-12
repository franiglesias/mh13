<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:14
 */

namespace Mh13\plugins\contents\application\article;


use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class GetArticleByAliasHandler
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

    public function handle(GetArticleByAlias $getArticleByAlias)
    {
        $specification = $this->specificationFactory->createPublishedArticleWithSlug($getArticleByAlias->getAlias());

        return $this->readmodel->getArticle($specification);
    }


}
