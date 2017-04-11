<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\Menu;
use PhpSpec\ObjectBehavior;


class MenuSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }
}
