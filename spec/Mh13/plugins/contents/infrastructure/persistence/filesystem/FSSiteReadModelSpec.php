<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\filesystem;

use Mh13\plugins\contents\exceptions\InvalidSite;
use Mh13\plugins\contents\infrastructure\persistence\filesystem\FSSiteReadModel;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;


class FSSiteReadModelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FSSiteReadModel::class);
    }

    public function let()
    {
        $this->beConstructedWith($this->getConfigFile());
    }

    private function getConfigFile()
    {
        $root = vfsStream::setup('config');
        vfsStream::newFile('sites.yml')->withContent($this->getData())->at($root);

        return vfsStream::url('config/sites.yml');

    }

    /**
     *
     */
    private function getData()
    {

        return /** @lang Yaml */
            <<<EOD
sites:
    main:
        description: 'Main site'
        title: 'Main'
        blogs:
            - blog1
            - blog2
            - blog3
    aux:
        title: 'Aux site'
        description: 'Auxiliar site'
        blogs:
            - blog1
            - blog5
            - blog7
EOD;


    }

    public function it_throws_exception_if_no_site_with_that_name_is_configured()
    {
        $this->shouldThrow(InvalidSite::class)->during('getBlogs', ['other']);
    }

    public function it_loads_list_of_blogs_for_site()
    {
        $this->getBlogs('main')->shouldBe(['blog1', 'blog2', 'blog3']);
        $this->getBlogs('aux')->shouldBe(['blog1', 'blog5', 'blog7']);
    }

    public function it_returns_site_data()
    {
        $this->getWithSlug('main')->shouldBe(['name' => 'main', 'title' => 'Main', 'description' => 'Main site']);
    }
}
