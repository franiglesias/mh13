<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 1/5/17
 * Time: 13:55
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;

use PHPUnit\Framework\TestCase;


class ArticleWithSlugTest extends TestCase
{
    public function test_it_returns_the_where_clause()
    {
        $specification = new ArticleWithSlug('article');
        $this->assertEquals('article.slug = :slug', $specification->getConditions());
        $this->assertEquals(['slug' => 'article'], $specification->getParameters());
    }
}
