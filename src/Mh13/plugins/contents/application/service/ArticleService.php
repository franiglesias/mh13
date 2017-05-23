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
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;
use Mh13\shared\web\twig\filter\Summarizer;


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


    public function __construct(
        ArticleReadModel $readmodel,
        ArticleSpecificationFactory $specificationFactory
    ) {
        $this->readmodel = $readmodel;
        $this->specificationFactory = $specificationFactory;
    }

    public function getArticleWithSlug(string $slug)
    {
        $specification = $this->specificationFactory->createPublishedArticleWithSlug($slug);

        return $this->readmodel->getArticle($specification);

    }

    public function getArticlesFromRequest(ArticleRequest $request)
    {
        $specification = $this->specificationFactory->createFromCatalogRequest($request);

        $articles = $this->readmodel->ignoringStickFlag($request->ignoreSticky())->from($request->from())->max(
                $request->max()
            )->findArticles($specification)
            ;

        return array_map(
            function ($article) {
                $article['abstract'] = Summarizer::summarizeText($article['content']);

                return $article;
            },
            $articles
        );

    }

    public function getArticlesCountForRequest(ArticleRequest $request)
    {
        $specification = $this->specificationFactory->createFromCatalogRequest($request);

        return $this->readmodel->ignoringStickFlag($request->ignoreSticky())->from($request->from())->max(
            $request->max()
        )->count($specification)
            ;
    }

}
