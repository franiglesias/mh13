<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 15:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Statement;
use Mh13\plugins\contents\exceptions\InvalidBlog;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\DBalBlogSpecification;
use PHPUnit\Framework\TestCase;


class DbalBlogReadModelTest extends TestCase
{
    private $dbalBlogReadModel;

    public function setUp()
    {
        $this->dbalBlogReadModel = new DbalBlogReadModel();
    }

    public function test_it_fetches_and_returns_a_blog()
    {
        $specification = $this->prepareSpecification();

        $result = $this->dbalBlogReadModel->getBlog($specification->reveal());
        $this->assertEquals('theBlog', $result);
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function prepareSpecification(): \Prophecy\Prophecy\ObjectProphecy
    {
        $specification = $this->prophesize(DBalBlogSpecification::class);
        $statement = $this->prophesize(Statement::class);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $statement->fetch()->shouldBeCalled()->willReturn('theBlog');

        return $specification;
    }

    public function test_it_throws_exception_if_invalid_name_for_blog_is_provided()
    {
        $specification = $this->prepareSpecificationWithNoResults();

        $this->expectException(InvalidBlog::class);
        $this->dbalBlogReadModel->getBlog($specification->reveal());
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function prepareSpecificationWithNoResults(): \Prophecy\Prophecy\ObjectProphecy
    {
        $specification = $this->prophesize(DBalBlogSpecification::class);
        $statement = $this->prophesize(Statement::class);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $statement->fetch()->shouldBeCalled()->willReturn(false);

        return $specification;
    }


}
