<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 1/5/17
 * Time: 13:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification\ArticleNotFromBlogs;
use PHPUnit\Framework\TestCase;


class ArticleNotFromBlogsTest extends TestCase
{

    public function test_it_returns_the_where_clause()
    {
        $specification = new ArticleNotFromBlogs(['blog3', 'blog4']);
        $expected = 'blog.slug NOT IN (:excluded)';
        $this->assertEquals($expected, $specification->getConditions());
        $this->assertEquals(['excluded' => ['blog3', 'blog4']], $specification->getParameters());
        $this->assertEquals(['excluded' => Connection::PARAM_STR_ARRAY], $specification->getTypes());
    }
}
