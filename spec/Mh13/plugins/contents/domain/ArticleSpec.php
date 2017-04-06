<?php

namespace spec\Mh13\plugins\contents\domain;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\ArticleId;
use PhpSpec\ObjectBehavior;


class ArticleSpec extends ObjectBehavior
{
    public function let(ArticleId $articleId, ArticleContent $content)
    {

        $this->beConstructedWith($articleId, $content);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    public function it_can_modify_content(ArticleContent $newContent, $content)
    {
        $this->modify($newContent);

        $this->getContent()->shouldBe($newContent);
        $this->getContent()->shouldNotBe($content);
    }

    public function it_can_be_published()
    {
        $this->publish();
        $this->getStatus()->shouldBe(Article::PUBLISHED);
    }

    public function it_can_be_published_at_specific_date(\DateTimeImmutable $date)
    {
        $this->publish($date);
        $this->getStatus()->shouldBe(Article::PUBLISHED);
        $this->getPubDate()->shouldBe($date);
    }

    public function it_can_be_set_to_expire_at_specific_date(\DateTimeImmutable $date)
    {
        $this->setToExpireAt($date);
        $this->willExpireAt()->shouldBe($date);
    }

}
