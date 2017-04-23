<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:14
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\ArticleReadModel;
use Mh13\plugins\contents\application\service\catalog\ArticleRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


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

    public function __construct(ArticleReadModel $readmodel, ArticleSpecificationFactory $specificationFactory)
    {

        $this->readmodel = $readmodel;
        $this->specificationFactory = $specificationFactory;
    }

    public function getArticleBySlug(string $slug)
    {
        $specification = $this->specificationFactory->createPublishedArticleWithSlug($slug);
        $article = $this->readmodel->getArticle($specification);

        return $article;
    }

    public function getArticlesFromRequest(ArticleRequest $request)
    {
        $specification = $this->specificationFactory->createFromCatalogRequest($request);
        $articles = $this->readmodel->findArticles($specification);
        $result = [];
        foreach ($articles as $article) {
            $result[] = [
                'article' => [
                    'id' => $article['article_id'],
                    'title' => $article['article_title'],
                    'slug' => $article['article_slug'],
                    'content' => $article['article_content'],
                    'pubDate' => $article['article_pubDate'],
                    'expiration' => $article['article_expiration'],
                ],
                'blog' => [
                    'title' => $article['blog_title'],
                    'slug' => $article['blog_slug'],
                ],
                'image' => [
                    'path' => $article['image_path'],

                ],
            ];
        }

        return $result;

    }

}
