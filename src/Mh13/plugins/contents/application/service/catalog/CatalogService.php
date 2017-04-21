<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 17:01
 */

namespace Mh13\plugins\contents\application\service\catalog;


use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class CatalogService
{

    /**
     * @var ArticleSpecificationFactory
     */
    private $specificationFactory;

    /**
     * CatalogService constructor.
     *
     * @param ArticleSpecificationFactory $specificationFactory
     *
     * @internal param ArticleRepository $repository
     */
    public function __construct(ArticleSpecificationFactory $specificationFactory)
    {
        $this->specificationFactory = $specificationFactory;
    }

    /**
     * @param CatalogRequest $request
     *
     * @return array
     */
    public function getArticles(CatalogRequest $request)
    {
        $query = $this->specificationFactory->createFromCatalogRequest($request);
        $articles = $query->fetch();
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
