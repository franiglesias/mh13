<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:41
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Mh13\plugins\contents\exceptions\InvalidStaticPage;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetPageWithSlug;
use PHPUnit\Framework\TestCase;


class DbalStaticPageReadModelTest extends TestCase
{
    private $readmodel;

    public function test_it_retrieves_page_with_a_slug()
    {
        $page = new \stdClass();
        $specification = $this->prophesize(GetPageWithSlug::class);
        $builder = $this->prophesize(QueryBuilder::class);
        $statement = $this->prophesize(Statement::class);
        $statement->fetch()->shouldBeCalled()->willReturn($page);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $this->readmodel = new DbalStaticPageReadModel();

        $this->assertEquals($page, $this->readmodel->getPage($specification->reveal()));
    }

    public function test_it_throws_exception_if_no_page_found()
    {
        $specification = $this->prophesize(GetPageWithSlug::class);
        $builder = $this->prophesize(QueryBuilder::class);
        $statement = $this->prophesize(Statement::class);
        $statement->fetch()->shouldBeCalled()->willReturn(false);
        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $this->readmodel = new DbalStaticPageReadModel();
        $this->expectException(InvalidStaticPage::class);
        $this->readmodel->getPage($specification->reveal());
    }
}
