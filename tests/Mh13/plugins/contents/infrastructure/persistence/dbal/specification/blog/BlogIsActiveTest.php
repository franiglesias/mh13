<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:39
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use PHPUnit\Framework\TestCase;


class BlogIsActiveTest extends TestCase
{

    public function test_it_returns_the_where_clause()
    {
        $expressionBuilder = $this->getExpressionBuilder();
        $specification = new BlogIsActive($expressionBuilder);
        $this->assertEquals('active = 1', $specification->getConditions());
    }

    /**
     * @return ExpressionBuilder
     */
    protected function getExpressionBuilder(): ExpressionBuilder
    {
        $connection = $this->prophesize(Connection::class);
        $expressionBuilder = new ExpressionBuilder($connection->reveal());

        return $expressionBuilder;
    }

    public function test_it_can_be_combined_with_another_specification()
    {
        $expressionBuilder = $this->getExpressionBuilder();
        $blogIsActive = new BlogIsActive($expressionBuilder);
        $combined = $blogIsActive->and(new BlogWithSlug('blog_slug'));
        $expected = $expressionBuilder->andX('active = 1', 'slug = :slug');
        $this->assertEquals($expected, $combined->getConditions());
        $this->assertEquals(['slug' => 'blog_slug'], $combined->getParameters());
    }
}
