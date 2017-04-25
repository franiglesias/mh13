<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 15:31
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Statement;
use Mh13\plugins\contents\exceptions\ArticleNotFound;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\DbalArticleSpecification;
use PHPUnit\Framework\TestCase;


class DBalArticleReadModelTest extends TestCase
{
    private $dbalArticleReadModel;

    public function setUp()
    {
        $this->dbalArticleReadModel = new DBalArticleReadModel();
    }

    public function test_it_fetches_and_returns_an_article()
    {
        $specification = $this->prepareSpecificationThatReturnsAnArticle();

        $article = $this->dbalArticleReadModel->getArticle($specification->reveal());
        $this->assertEquals('theArticle', $article);

    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function prepareSpecificationThatReturnsAnArticle(): \Prophecy\Prophecy\ObjectProphecy
    {
        $specification = $this->prophesize(DbalArticleSpecification::class);
        $statement = $this->prophesize(Statement::class);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $statement->fetch()->shouldBeCalled()->willReturn('theArticle');

        return $specification;
    }

    public function test_it_throws_exception_if_an_article_is_not_found()
    {
        $specification = $this->prepareSpecificationThatDoesNotReturnTheArticle();

        $this->expectException(ArticleNotFound::class);
        $article = $this->dbalArticleReadModel->getArticle($specification->reveal());

    }

    protected function prepareSpecificationThatDoesNotReturnTheArticle(): \Prophecy\Prophecy\ObjectProphecy
    {
        $specification = $this->prophesize(DbalArticleSpecification::class);
        $statement = $this->prophesize(Statement::class);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $statement->fetch()->shouldBeCalled()->willReturn(false);

        return $specification;
    }

    public function test_it_returns_empty_if_a_resultset_is_empty()
    {
        $specification = $this->prepareSpecificationThatDoesNotFoundAnyArticles();
        $article = $this->dbalArticleReadModel->findArticles($specification->reveal());
        $this->assertEquals(false, $article);
    }

    protected function prepareSpecificationThatDoesNotFoundAnyArticles(): \Prophecy\Prophecy\ObjectProphecy
    {
        $specification = $this->prophesize(DbalArticleSpecification::class);
        $statement = $this->prophesize(Statement::class);

        $specification->getQuery()->shouldBeCalled()->willReturn($statement);
        $statement->fetchAll()->shouldBeCalled()->willReturn(false);

        return $specification;
    }
}
