<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\cakephp;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;
use Mh13\plugins\contents\infrastructure\persistence\cakephp\CakeArticleMapper;
use Mh13\plugins\contents\infrastructure\persistence\cakephp\CakeArticleRepository;
use Mh13\shared\persistence\CakeStore;
use PhpSpec\ObjectBehavior;


class CakeArticleRepositorySpec extends ObjectBehavior
{
    public function let(CakeStore $store, CakeArticleMapper $mapper)
    {
        $this->beConstructedWith($store, $mapper);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(CakeArticleRepository::class);
        $this->shouldImplement(ArticleRepository::class);
    }

    public function it_stores_an_article(Article $article, CakeStore $store, CakeArticleMapper $mapper)
    {
        $mapper->toArray($article)->shouldBeCalled()->willReturn(['data']);
        $store->save(['data']);
        $this->store($article);
    }

    public function it_retrieves_an_article(ArticleId $articleId, Article $article, CakeStore $store, CakeArticleMapper $mapper)
    {
        $articleId->getId()->shouldBeCalled()->willReturn('01');
        $store->read(null, '01')->shouldBeCalled()->willReturn(['data']);
        $mapper->toArticle(['data'])->shouldBeCalled()->willReturn($article);

        $this->retrieve($articleId)->shouldBe($article);
    }

    public function it_throws_exception_if_article_is_not_found(
        ArticleId $articleId,
        Article $article,
        CakeStore $store,
        CakeArticleMapper $mapper
    ) {
        $articleId->getId()->shouldBeCalled()->willReturn('01');
        $store->read(null, '01')->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(ContentException::class)->during('retrieve', [$articleId]);

    }
}
