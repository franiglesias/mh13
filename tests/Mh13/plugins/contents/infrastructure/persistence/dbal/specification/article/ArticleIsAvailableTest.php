<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 1/5/17
 * Time: 13:32
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleIsAvailable;
use PHPUnit\Framework\TestCase;


class ArticleIsAvailableTest extends TestCase
{
    public function test_it_returns_the_where_clause()
    {
        $specification = new ArticleIsAvailable();
        $expected = 'article.status = :published and article.pubDate <= now() and (article.expiration is null or article.expiration > now()) and blog.active = 1';
        $this->assertEquals($expected, $specification->getConditions());
        $this->assertEquals(['published' => Article::PUBLISHED], $specification->getParameters());

    }
}
