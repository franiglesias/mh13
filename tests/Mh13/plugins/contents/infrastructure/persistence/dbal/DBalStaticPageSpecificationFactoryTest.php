<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:10
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetPageWithSlug;
use PHPUnit\Framework\TestCase;


class DBalStaticPageSpecificationFactoryTest extends TestCase
{
    private $factory;

    public function setUp()
    {
        $connection = $this->prophesize(Connection::class);
        $builder = $this->prophesize(QueryBuilder::class);
        $connection->createQueryBuilder()->shouldBeCalled()->willReturn($builder);
        $this->factory = new DBalStaticPageSpecificationFactory($connection->reveal());
    }

    public function test_it_creates_GetPageWithSlug_specification()
    {
        $spec = $this->factory->createGetPageWithSlug('slug');
        $this->assertInstanceOf(GetPageWithSlug::class, $spec);
    }
}
