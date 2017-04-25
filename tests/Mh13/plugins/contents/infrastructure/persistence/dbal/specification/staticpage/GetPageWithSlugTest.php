<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:20
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use PHPUnit\Framework\TestCase;


class GetPageWithSlugTest extends TestCase
{
    private $specification;


    public function test_it_should_build_the_right_query()
    {
        $statement = $this->prophesize(Statement::class);
        $builder = $this->prophesize(QueryBuilder::class);
        $builder->select('*')->shouldBeCalled()->willReturn($builder);
        $builder->from('static_pages', 'static')->shouldBeCalled()->willReturn($builder);
        $builder->where('static.slug = ?')->shouldBeCalled()->willReturn($builder);
        $builder->setParameter(0, 'slug')->shouldBeCalled()->willReturn($builder);
        $builder->execute()->shouldBeCalled()->willReturn($statement);
        $this->specification = new GetPageWithSlug($builder->reveal(), 'slug');
        $this->assertEquals($statement->reveal(), $this->specification->getQuery());
    }
}
