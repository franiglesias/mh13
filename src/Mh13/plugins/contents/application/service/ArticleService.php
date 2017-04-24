<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:14
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\ArticleReadModel;
use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\application\utility\mapper\ArticleMapper;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\model\article\FullArticleView;


class ArticleService
{

    /**
     * @var ArticleReadModel
     */
    private $readmodel;
    /**
     * @var ArticleSpecificationFactory
     */
    private $specificationFactory;
    /**
     * @var ArticleMapper
     */
    private $mapper;

    public function __construct(
        ArticleReadModel $readmodel,
        ArticleSpecificationFactory $specificationFactory,
        ArticleMapper $mapper
    )
    {

        $this->readmodel = $readmodel;
        $this->specificationFactory = $specificationFactory;
        $this->mapper = $mapper;
    }

    public function getArticleWithSlug(string $slug)
    {
        $specification = $this->specificationFactory->createPublishedArticleWithSlug($slug);
        $article = $this->readmodel->getArticle($specification);

        return $this->mapper->mapToViewModel($article, new FullArticleView());
    }

    public function getArticlesFromRequest(ArticleRequest $request)
    {
        $specification = $this->specificationFactory->createFromCatalogRequest($request);
        $articles = $this->readmodel->findArticles($specification);

        return $this->mapper->fromDbToView($articles);
    }

}
