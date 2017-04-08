<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\GetArticleRequest;
use Mh13\plugins\contents\application\service\GetArticleService;
use Mh13\plugins\contents\application\service\SlugConverter;
use Mh13\plugins\contents\application\service\SlugServiceException;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;
use PhpSpec\ObjectBehavior;


class GetArticleServiceSpec extends ObjectBehavior
{
    public function let(ArticleRepository $repository, SlugConverter $slugService)
    {
        $this->beConstructedWith($repository, $slugService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetArticleService::class);
    }

    public function it_returns_an_article(
        Article $article,
        ArticleId $id,
        GetArticleRequest $request,
        ArticleRepository $repository,
        SlugConverter $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willReturn($id);
        $repository->retrieve($id)->shouldBeCalled()->willReturn($article);
        $this->execute($request)->shouldBe($article);
    }

    public function it_throws_exception_if_article_is_not_found(
        Article $article,
        ArticleId $id,
        GetArticleRequest $request,
        ArticleRepository $repository,
        SlugConverter $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willReturn($id);
        $repository->retrieve($id)->shouldBeCalled()->willThrow(ContentException::class);
        $this->shouldThrow(ContentException::class)->during('execute', [$request]);
    }

    public function it_throws_exception_if_slug_is_not_found(
        Article $article,
        ArticleId $id,
        GetArticleRequest $request,
        ArticleRepository $repository,
        SlugConverter $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willThrow(SlugServiceException::class);
        $this->shouldThrow(ContentException::class)->during('execute', [$request]);
    }
}
