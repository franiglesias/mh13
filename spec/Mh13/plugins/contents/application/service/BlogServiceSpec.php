<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalReadOnlyBlogRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\ActiveBlogWithSlug;
use PhpSpec\ObjectBehavior;


class BlogServiceSpec extends ObjectBehavior
{
    public function let(BlogSpecificationFactory $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DbalReadOnlyBlogRepository::class);
    }

    public function it_can_request_a_blog(BlogSpecificationFactory $factory, ActiveBlogWithSlug $query)
    {
        $factory->createBlogWithSlug('slug')->shouldBeCalled()->willReturn($query);
        $query->fetch()->shouldBeCalled()->willReturn(
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
