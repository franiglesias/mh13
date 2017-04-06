<?php

namespace spec\Mh13\plugins\contents\domain;

use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\exceptions\InvalidArticleContentBody;
use Mh13\plugins\contents\exceptions\InvalidArticleContentTitle;
use PhpSpec\ObjectBehavior;


class ArticleContentSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Title', 'Content');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleContent::class);
    }

    public function it_must_have_a_title()
    {

        $this->beConstructedWith(null, 'Content');
        $this->shouldThrow(InvalidArticleContentTitle::class)->duringInstantiation();
    }

    public function it_must_have_a_body()
    {
        $this->beConstructedWith('Title', '');
        $this->shouldThrow(InvalidArticleContentBody::class)->duringInstantiation();
    }
}
