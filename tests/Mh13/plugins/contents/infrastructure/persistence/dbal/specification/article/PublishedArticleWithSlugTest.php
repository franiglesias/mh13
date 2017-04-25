<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 15:38
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;


class PublishedArticleWithSlugTest extends TestCase
{


    public function test_it_prepares_the_desired_query()
    {
        $builder = $this->prophesize(QueryBuilder::class);
        $statement = $this->prophesize(Statement::class);
        $builder->select("articles.*", "blogs.slug as blog_slug", "images.path as image")->willReturn($builder);
        $builder->from("items", "articles")->willReturn($builder);
        $builder->leftJoin("articles", "blogs", "blogs", "articles.channel_id = blogs.id")->willReturn($builder);
        $builder->leftJoin(
            "articles",
            "uploads",
            "images",
            "images.model = \"Item\" and images.foreign_key = articles.id"
        )->willReturn($builder)
        ;
        $builder->where("articles.slug = ?")->willReturn($builder);
        $builder->setParameter(0, 'slug')->willReturn($builder);
        $builder->execute()->shouldBeCalled()->willReturn($statement->reveal());

        $specification = new PublishedArticleWithSlug($builder->reveal(), 'slug');

        $this->assertEquals($statement->reveal(), $specification->getQuery());
    }
}
