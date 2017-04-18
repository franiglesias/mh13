<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\MenuBar;
use Mh13\shared\web\menus\MenuBarLoader;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;


class MenuBarLoaderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($this->getConfigFile());
    }

    private function getConfigFile()
    {
        $root = vfsStream::setup('config');
        vfsStream::newFile('menus.yml')->withContent($this->getData())->at($root);

        return vfsStream::url('config/menus.yml');

    }

    /**
     *
     */
    private function getData()
    {
        return <<<EOD
bars:
    main:
        label: Main
        menus:
            - menu1
            - menu2

menus:
    menu1:
        help: ''
        icon: ''
        label: ''
        url: ''
        access: '0'
        items:
            - { label: 'Item 1', url: '/path/to/item/1', access: '0', help: '', icon: '', class: '' }
            - { label: 'Item 2', url: '/path/to/item/2', access: '0', help: '', icon: '', class: '' }
            - separator
            - { label: 'Item 3', url: '/path/to/item/3', access: '0', help: '', icon: '', class: '' }
            - { label: 'Item 4', url: '/path/to/item/4', access: '0', help: '', icon: '', class: '' }
    menu2:
        help: ''
        icon: ''
        label: ''
        url: ''
        access: '0'
        items:
            - { label: 'ItemM2 1', url: '/path/to/item2/1', access: '0', help: '', icon: '', class: '' }
            - { label: 'ItemM2 2', url: '/path/to/item2/2', access: '0', help: '', icon: '', class: '' }
        
EOD;


    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MenuBarLoader::class);
    }

    public function it_reads_menu_data()
    {
        $this->load('main')->shouldBeAnInstanceOf(MenuBar::class);
        $this->load('main')->getLabel()->shouldBe('Main');
        $this->load('main')->getMenus()->shouldHaveCount(2);
    }

}
