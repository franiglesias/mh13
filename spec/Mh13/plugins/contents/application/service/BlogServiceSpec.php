<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\BlogService;
use Mh13\plugins\contents\domain\Blog;
use Mh13\plugins\contents\domain\BlogId;
use Mh13\plugins\contents\domain\BlogRepository;
use PhpSpec\ObjectBehavior;


class BlogServiceSpec extends ObjectBehavior
{
    public function let(BlogRepository $blogRepository)
    {
        $this->beConstructedWith($blogRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BlogService::class);
    }

    public function it_can_request_a_blog(BlogRepository $blogRepository)
    {
        $blogRepository->getBySlugOrFail('slug')->shouldBeCalled()->willReturn(
            new Blog(new BlogId('blog1'), 'Blog Title', 'slug')
        )
        ;
        $this->getBlog('slug')->shouldBeArray();
        $this->getBlog('slug')->shouldBe(
            [
                'id' => 'blog1',
                'title' => 'Blog Title',
                'slug' => 'slug',
                'tagline' => null,
                'icon' => null,
                'description' => null,
                'image' => null,
            ]
        )
        ;
    }
}
