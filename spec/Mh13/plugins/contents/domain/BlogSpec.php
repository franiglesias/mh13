<?php

namespace spec\Mh13\plugins\contents\domain;

use Mh13\plugins\contents\domain\Blog;
use Mh13\plugins\contents\domain\BlogId;
use PhpSpec\ObjectBehavior;


class BlogSpec extends ObjectBehavior
{
    public function let(BlogId $id)
    {
        $this->beConstructedWith($id, 'Title', 'Tagline', 'Description');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Blog::class);
    }


}
