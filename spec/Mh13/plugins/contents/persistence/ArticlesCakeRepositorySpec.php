<?php

namespace spec\Mh13\plugins\contents\persistence;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\persistence\ArticlesCakeRepository;
use Mh13\plugins\contents\persistence\ArticleMapper;
use Mh13\shared\persistence\CakeStore;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mh13\plugins\contents\domain\ArticleRepository;


class ArticlesCakeRepositorySpec extends ObjectBehavior
{
    public function let(CakeStore $store, ArticleMapper $mapper)
    {
        $this->beConstructedWith($store, $mapper);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(ArticlesCakeRepository::class);
        $this->shouldImplement(ArticleRepository::class);
    }

    public function it_stores_an_article(Article $article, CakeStore $store, ArticleMapper $mapper)
    {
        $mapper->toArray($article)->shouldBeCalled()->willReturn(['data']);
        $store->save(['data']);
        $this->store($article);
    }

    public function it_retrieves_an_article(ArticleId $articleId, Article $article, CakeStore $store, ArticleMapper $mapper)
    {
        $articleId->getId()->shouldBeCalled()->willReturn('01');
        $store->read(null, '01')->shouldBeCalled()->willReturn(['data']);
        $mapper->toArticle(['data'])->shouldBeCalled()->willReturn($article);

        $this->retrieve($articleId)->shouldBe($article);
    }
}
