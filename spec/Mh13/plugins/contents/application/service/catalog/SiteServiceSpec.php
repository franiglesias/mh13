<?php

namespace spec\Mh13\plugins\contents\application\service\catalog;

use Mh13\plugins\contents\application\service\catalog\SiteService;
use Mh13\plugins\contents\exceptions\InvalidSite;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;


class SiteServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SiteService::class);
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
        return <<<EOD
sites:
    main:
        - blog1
        - blog2
        - blog3
    aux:
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

}
