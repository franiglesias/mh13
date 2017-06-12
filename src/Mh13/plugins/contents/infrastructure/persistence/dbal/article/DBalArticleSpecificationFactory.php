<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\article;


use Mh13\plugins\contents\application\article\request\ArticleRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleFromBlogs;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleIsAvailable;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleNotFromBlogs;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\PublishedArticleWithSlug;


class DBalArticleSpecificationFactory implements ArticleSpecificationFactory
{

    public function createFromCatalogRequest(ArticleRequest $catalogRequest)
    {
        $articleIsAvailable = $this->createArticleIsAvailable();
        if ($catalogRequest->blogs()) {
            $articleIsAvailable = $articleIsAvailable->and(
                $this->createArticleFromBlogs($catalogRequest->blogs())
            );
        }
        if ($catalogRequest->excludedBlogs()) {
            $articleIsAvailable = $articleIsAvailable->and(
                $this->createArticleNotFromBlogs($catalogRequest->excludedBlogs())
            );
        }

        return $articleIsAvailable;
    }

    public function createArticleIsAvailable()
    {
        return new ArticleIsAvailable();
    }

    public function createArticleFromBlogs(array $blogs)
    {
        return new ArticleFromBlogs($blogs);
    }

    public function createArticleNotFromBlogs(array $excludedBlogs)
    {
        return new ArticleNotFromBlogs($excludedBlogs);
    }

    public function createPublishedArticleWithSlug(string $slug)
    {
        $articleIsAvailable = $this->createArticleIsAvailable();

        return $articleIsAvailable->and($this->createArticleWithSlug($slug));

    }

    public function createArticleWithSlug(string $slug)
    {
        return new ArticleWithSlug($slug);
    }
}
