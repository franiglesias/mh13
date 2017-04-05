<?php

namespace spec\Mh13\plugins\contents\domain;

use DateTimeInterface;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\Author;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArticleSpec extends ObjectBehavior
{
    public function let(ArticleId $articleId, ArticleContent $content, Author $author)
    {

        $this->beConstructedWith($articleId, $content, $author);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    public function it_can_have_several_authors(Author $coauthor)
    {
        $this->addAuthor($coauthor);

        $this->getAuthors()->shouldHaveCount(2);
    }

    public function it_silently_avoids_to_add_an_existent_author(Author $author)
    {
        $this->addAuthor($author);

        $this->getAuthors()->shouldHaveCount(1);
    }

    public function it_can_remove_authors(Author $coauthor, $author)
    {
        $author->isEqual($coauthor)->willReturn(false);
        $coauthor->isEqual($coauthor)->willReturn(true);
        $this->addAuthor($coauthor);

        $this->removeAuthor($coauthor);

        $this->getAuthors()->shouldHaveCount(1);
    }

    public function it_can_remove_authors_except_one($author)
    {
        $author->isEqual($author)->willReturn(true);

        $this->removeAuthor($author);

        $this->getAuthors()->shouldHaveCount(1);
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
    }


}
