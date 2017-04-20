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
     *
     * @param ArticleRepository           $repository
     * @param ArticleSpecificationFactory $specificationFactory
     */
    public function __construct(ArticleRepository $repository, ArticleSpecificationFactory $specificationFactory)
    {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    /**
     * @param CatalogRequest $request
     *
     * @return array
     */
    public function getArticles(CatalogRequest $request)
    {
        $articles = $this->repository->findAll($this->specificationFactory->createFromCatalogRequest($request));
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

                ]
            ];
        }

        return $result;
    }
}
