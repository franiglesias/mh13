<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\SlugService;
use PhpSpec\ObjectBehavior;


class SlugServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SlugService::class);
    }
}
