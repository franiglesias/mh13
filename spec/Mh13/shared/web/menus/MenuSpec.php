<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\Menu;
use Mh13\shared\web\menus\MenuItem;
use PhpSpec\ObjectBehavior;


class MenuSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('aMenu', 'Menu', '/path/to/meny', 'icon', 'help', 0);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }

    public function it_can_add_items()
    {
        $data = [
            'label' => 'Principal',
            'url' => '/',
            'access' => '0',
            'help' => '',
            'icon' => 'icon',
            'class' => 'class',
        ];
        $item = MenuItem::fromConfiguration($data);
        $this->addItem($item);
    }

    public function it_can_be_created_from_configuration_data()
    {
        $title = 'global';
        $data = [
            'label' => 'Global',
            'icon' => 'icon',
            'url' => '/path/to/menu',
            'access' => 0,
            'items' => [
                [
                    'label' => 'Item 1',
                    'url' => '/path/to/option/1',
                    'access' => '0',
                    'help' => '',
                    'icon' => 'icon-1',
                    'class' => 'class-1',
                ],
                'separator',
                [
                    'label' => 'Item 2',
                    'url' => '/path/to/option/2',
                    'access' => '0',
                    'help' => '',
                    'icon' => 'icon-2',
                    'class' => '',
                ],
            ],
        ];
        $this->beConstructedThrough('fromConfiguration', [$title, $data]);
        $this->getLabel()->shouldBe('Global');
    }
}
