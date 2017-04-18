<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\Menu;
use Mh13\shared\web\menus\MenuBar;
use PhpSpec\ObjectBehavior;


class MenuBarSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('main', 'Main');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MenuBar::class);
    }

    public function it_can_add_menus_to_bar(Menu $menu, Menu $menu2)
    {
        $this->addMenu($menu);
        $this->getMenus()->shouldHaveCount(1);
        $this->addMenu($menu2);
        $this->getMenus()->shouldHaveCount(2);
    }

    public function it_can_be_built_from_configuration_data(Menu $menu, Menu $menu2)
    {
        $data = [
            'label' => 'Main',
            'menus' => [
                $menu,
                $menu2,
            ],
        ];
        $this->beConstructedThrough('fromConfiguration', ['main', $data]);
        $this->getLabel()->shouldBe('Main');
        $this->getMenus()->shouldHaveCount(2);

    }
}
