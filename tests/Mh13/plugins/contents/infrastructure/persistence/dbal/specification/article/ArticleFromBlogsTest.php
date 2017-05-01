<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 1/5/17
 * Time: 13:24
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;


class ArticleFromBlogsTest extends TestCase
{
    public function test_it_gives_the_right_conditions()
    {
        $specification = new ArticleFromBlogs(['blog1', 'blog2']);
        $this->assertEquals('blog.slug IN (:blogs)', $specification->getConditions());
        $this->assertEquals(['blogs' => ['blog1', 'blog2']], $specification->getParameters());
        $this->assertEquals(['blogs' => Connection::PARAM_STR_ARRAY], $specification->getTypes());
    }
}
