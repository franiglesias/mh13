<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\ArticleRequest;
use Mh13\plugins\contents\application\service\GetArticleBySlug;
use Mh13\plugins\contents\application\service\SlugService;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
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
        ArticleRequest $request,
        ArticleRepository $repository,
        SlugService $slugService
    ) {
        $request->getSlug()->shouldBeCalled()->willReturn('slug');
        $slugService->mapToId('slug')->shouldBeCalled()->willReturn($id);
        $repository->retrieve($id)->shouldBeCalled()->willReturn($article);
        $this->execute($request)->shouldBe($article);
    }
}
