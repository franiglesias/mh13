<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 13:04
 */

namespace Mh13\plugins\contents\infrastructure\persistence\cakephp;


use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class CakeArticleSpecificationFactory implements ArticleSpecificationFactory
{
    /**
     * @return mixed
     */
    public function createLastArticles()
    {
        // TODO: Implement createLastArticles() method.
    }

    public function createFromCatalogRequest(ArticleRequest $catalogRequest)
    {
        // TODO: Implement createFromCatalogRequest() method.
    }

    public function createPublishedArticleWithSlug(string $slug)
    {
        // TODO: Implement createPublishedArticleWithSlug() method.
    }

    public function createArticleIsAvailable()
    {
        // TODO: Implement createArticleIsAvailable() method.
    }

    public function createArticleFromBlogs(array $blogs)
    {
        // TODO: Implement createArticleFromBlogs() method.
    }

    public function createArticleWithSlug(string $slug)
    {
        // TODO: Implement createArticleWithSlug() method.
    }

    public function createArticleNotFromBlogs(array $excludedBlogs)
    {
        // TODO: Implement createArticleNotFromBlogs() method.
    }
}
