<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\ArticleService;
use Mh13\plugins\contents\application\service\GetArticleRequest;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;
use PhpSpec\ObjectBehavior;


class GetArticleServiceSpec extends ObjectBehavior
{
    public function let(ArticleRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleService::class);
    }

    public function it_returns_an_article(
        Article $article,
        GetArticleRequest $request,
        ArticleRepository $repository
    ) {
        $request->getId()->shouldBeCalled()->willReturn('id');
        $repository->retrieve(new ArticleId('id'))->shouldBeCalled()->willReturn($article);
        $this->execute($request)->shouldBe($article);
    }

    public function it_throws_exception_if_article_is_not_found(
        Article $article,
        GetArticleRequest $request,
        ArticleRepository $repository
    ) {
        $request->getId()->shouldBeCalled()->willReturn('id');
        $repository->retrieve(new ArticleId('id'))->shouldBeCalled()->willThrow(ContentException::class);
        $this->shouldThrow(ContentException::class)->during('execute', [$request]);
    }


}
