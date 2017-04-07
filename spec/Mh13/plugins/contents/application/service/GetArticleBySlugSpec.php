<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\GetArticleBySlug;
use Mh13\plugins\contents\application\service\GetArticleBySlugRequest;
use Mh13\plugins\contents\application\service\SlugService;
use Mh13\plugins\contents\application\service\SlugServiceException;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;
use PhpSpec\ObjectBehavior;


class GetArticleBySlugSpec extends ObjectBehavior
{
    public function let(ArticleRepository $repository, SlugService $slugService)
    {
        $this->beConstructedWith($repository, $slugService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetArticleBySlug::class);
    }

    public function it_returns_an_article(
        Article $article,
        ArticleId $id,
        GetArticleBySlugRequest $request,
        ArticleRepository $repository,
        SlugService $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willReturn($id);
        $repository->retrieve($id)->shouldBeCalled()->willReturn($article);
        $this->execute($request)->shouldBe($article);
    }

    public function it_throws_exception_if_article_is_not_found(
        Article $article,
        ArticleId $id,
        GetArticleBySlugRequest $request,
        ArticleRepository $repository,
        SlugService $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willReturn($id);
        $repository->retrieve($id)->shouldBeCalled()->willThrow(ContentException::class);
        $this->shouldThrow(ContentException::class)->during('execute', [$request]);
    }

    public function it_throws_exception_if_slug_is_not_found(
        Article $article,
        ArticleId $id,
        GetArticleBySlugRequest $request,
        ArticleRepository $repository,
        SlugService $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willThrow(SlugServiceException::class);
        $this->shouldThrow(ContentException::class)->during('execute', [$request]);
    }
}
