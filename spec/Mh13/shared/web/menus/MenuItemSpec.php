<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\MenuItem;
use PhpSpec\ObjectBehavior;


class MenuItemSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Item label', '/path/to/item', 'icon', 'class', 'access', 'help');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MenuItem::class);
    }

    public function it_is_constructed_from_data_array()
    {
        $data = [
            'label' => 'Principal',
            'url' => '/',
            'access' => '0',
            'help' => '',
            'icon' => 'icon',
            'class' => 'class',
        ];
        $this->beConstructedThrough('fromConfiguration', [$data]);
        $this->getLabel()->shouldBe('Principal');
    }
}
