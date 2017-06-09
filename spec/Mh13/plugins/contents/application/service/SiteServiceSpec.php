<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\SiteService;
use Mh13\plugins\contents\application\site\SiteReadModel;
use PhpSpec\ObjectBehavior;


class SiteServiceSpec extends ObjectBehavior
{
    public function let(SiteReadModel $readModel)
    {
        $this->beConstructedWith($readModel);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SiteService::class);
    }

    public function it_can_return_a_site(SiteReadModel $readModel)
    {
        $readModel->getWithSlug('site')->shouldBeCalled()->willReturn(['thesite']);
        $this->getSiteWithSlug('site')->shouldBe(['thesite']);
    }
}
