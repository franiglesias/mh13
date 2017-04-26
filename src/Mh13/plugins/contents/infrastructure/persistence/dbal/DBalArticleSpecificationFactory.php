<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\ArticleFromBlogs;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\ArticleIsAvailable;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\ArticleNotFromBlogs;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\ArticleWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\PublishedArticleWithSlug;


class DBalArticleSpecificationFactory implements ArticleSpecificationFactory
{
    protected $expressionBuilder;
    /**
     * @var Connection
     */
    private $connection;


    /**
     * DBalArticleSpecificationFactory constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->expressionBuilder = $this->connection->createQueryBuilder()->expr();
    }

    public function createFromCatalogRequest(ArticleRequest $catalogRequest)
    {
        $articleIsAvailable = $this->createArticleIsAvailable();
        if ($catalogRequest->blogs()) {
            $articleIsAvailable = $articleIsAvailable->and($this->createArticleFromBlogs($catalogRequest->blogs()));
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
        return new ArticleIsAvailable($this->expressionBuilder);
    }

    public function createArticleFromBlogs(array $blogs)
    {
        return new ArticleFromBlogs($this->expressionBuilder, $blogs);
    }

    public function createArticleNotFromBlogs(array $excludedBlogs)
    {
        return new ArticleNotFromBlogs($this->expressionBuilder, $excludedBlogs);
    }

    public function createPublishedArticleWithSlug(string $slug)
    {
        $articleIsAvailable = $this->createArticleIsAvailable();

        return $articleIsAvailable->and($this->createArticleWithSlug($slug));

    }

    public function createArticleWithSlug(string $slug)
    {
        return new ArticleWithSlug($this->expressionBuilder, $slug);
    }
}
