<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\readmodel\BlogReadModel;
use Mh13\plugins\contents\application\service\BlogService;
use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\ActiveBlogWithSlug;
use PhpSpec\ObjectBehavior;


class BlogServiceSpec extends ObjectBehavior
{
    public function let(BlogReadModel $readModel, BlogSpecificationFactory $factory)
    {
        $this->beConstructedWith($readModel, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BlogService::class);
    }

    public function it_can_request_a_blog(
        BlogReadModel $readModel,
        BlogSpecificationFactory $factory,
        ActiveBlogWithSlug $specification
    ) {
        $factory->createBlogWithSlug('slug')->shouldBeCalled()->willReturn($specification);
        $readModel->getBlog($specification)->shouldBeCalled()->willReturn('blog_data');
        $this->getBlogWithSlug('slug')->shouldBe('blog_data');
    }
}
