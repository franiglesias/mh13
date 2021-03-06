<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\dbal\blog;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Mh13\plugins\contents\domain\Blog;
use Mh13\plugins\contents\domain\BlogId;
use Mh13\plugins\contents\domain\BlogRepository;
use Mh13\plugins\contents\exceptions\InvalidBlog;
use Mh13\plugins\contents\infrastructure\persistence\dbal\blog\DbalBlogRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class DbalBlogRepositorySpec extends ObjectBehavior
{
    public function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DbalBlogRepository::class);
        $this->shouldImplement(BlogRepository::class);
    }

    public function it_can_get_a_blog_by_its_slug(Connection $connection, Statement $statement)
    {
        $expected = new Blog(new BlogId('blogid'), 'blog_title', 'blog_slug');
        $connection->executeQuery('SELECT * FROM blogs WHERE blogs.slug = ?', ['blog_slug'])
            ->shouldBeCalled()
            ->willReturn($statement)
        ;
        $statement->fetch()->shouldBeCalled()->willReturn(
            [
                'id' => 'blogid',
                'title' => 'blog_title',
                'slug' => 'blog_slug',
                'tagline' => '',
                'description' => '',
                'icon' => '',
                'image' => '',
            ]
        )
        ;

        $this->getBySlugOrFail('blog_slug')->shouldBeLike($expected);
    }

    public function it_fails_if_no_blog_is_found(Connection $connection, Statement $statement)
    {
        $connection->executeQuery('SELECT * FROM blogs WHERE blogs.slug = ?', Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn($statement)
        ;
        $statement->fetch()->shouldBeCalled()->willReturn([]);
        $this->shouldThrow(InvalidBlog::class)->during('getBySlugOrFail', ['invalid_slug']);
    }
}
