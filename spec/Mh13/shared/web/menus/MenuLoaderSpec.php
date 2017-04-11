<?php

namespace spec\Mh13\shared\web\menus;

use Mh13\shared\web\menus\MenuLoader;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;


class MenuLoaderSpec extends ObjectBehavior
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
menus:
    global:
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
EOD;


    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MenuLoader::class);
    }

    public function it_reads_menu_data()
    {
        $this->load('global')->shouldBeArray();
        $this->load('global')['items']->shouldHaveCount(5);
        $this->load('global')['items'][2]->shouldBe('separator');
        $this->load('global')['items'][3]['label']->shouldBe('Item 3');
    }
}
