<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\SlugConverter;
use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\SlugRepository;
use PhpSpec\ObjectBehavior;


class SlugConverterSpec extends ObjectBehavior
{
    public function let(SlugRepository $slugRepository)
    {
        $this->beConstructedWith($slugRepository);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(SlugConverter::class);
    }

    public function it_converts_a_slug_to_an_id(SlugRepository $slugRepository)
    {
        $slugRepository->getIdOfSlug('slug')->shouldBeCalled()->willReturn('id');
        $this->mapToId('slug')->shouldBe('id');
    }


}
