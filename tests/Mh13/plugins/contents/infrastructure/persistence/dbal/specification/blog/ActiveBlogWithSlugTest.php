<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 15:21
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;


class ActiveBlogWithSlugTest extends TestCase
{
    private $specification;

    public function test_it_build_the_needed_query()
    {
        $builder = $this->prophesize(QueryBuilder::class);
        $statement = $this->prophesize(Statement::class);
        $builder->select('blogs.*')->shouldBeCalled()->willReturn($builder);
        $builder->from('blogs')->shouldBeCalled()->willReturn($builder);
        $builder->where('blogs.slug = ?')->shouldBeCalled()->willReturn($builder);
        $builder->andWhere('blogs.active = 1')->shouldBeCalled()->willReturn($builder);
        $builder->setParameter(0, 'slug')->shouldBeCalled()->willReturn($builder);
        $builder->execute()->willReturn($statement->reveal());
        $specification = new ActiveBlogWithSlug($builder->reveal(), 'slug');
        $this->assertEquals($statement->reveal(), $specification->getQuery());
    }


}
