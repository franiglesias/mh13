<?php

namespace spec\Mh13\plugins\contents\application\service\catalog;

use Mh13\plugins\contents\application\service\catalog\CatalogRequestBuilder;
use Mh13\plugins\contents\application\service\catalog\SiteService;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;


class CatalogRequestBuilderSpec extends ObjectBehavior
{

    public function let(SiteService $siteService)
    {
        $this->beConstructedWith($siteService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogRequestBuilder::class);
    }

    public function it_can_restrict_to_home_only()
    {
        $this->onlyHome()->shouldBe($this);
        $this->getCatalogRequest()->onlyHome()->shouldBe(true);
    }

    public function it_can_restrict_to_featured_only()
    {
        $this->onlyFeatured()->shouldBe($this);
        $this->getCatalogRequest()->onlyFeatured()->shouldBe(true);
    }

    public function it_can_restrict_to_public_only()
    {
        $this->onlyPublic()->shouldBe($this);
        $this->getCatalogRequest()->onlyPublic()->shouldBe(true);
    }

    public function it_can_handle_ignore_sticky_flag()
    {
        $this->ignoreSticky()->shouldBe($this);
        $this->getCatalogRequest()->ignoreSticky()->shouldBe(true);
    }

    public function it_can_allow_public_and_private()
    {
        $this->allowPrivate()->shouldBe($this);
        $this->getCatalogRequest()->onlyPublic()->shouldBe(false);
    }

    public function it_has_restrictions_by_default()
    {
        $this->getCatalogRequest()->onlyFeatured()->shouldBe(false);
        $this->getCatalogRequest()->onlyHome()->shouldBe(false);
        $this->getCatalogRequest()->onlyPublic()->shouldBe(true);
        $this->getCatalogRequest()->ignoreSticky()->shouldBe(false);
    }

    public function it_can_restrict_to_page()
    {
        $this->page(3)->shouldBe($this);
        $this->getCatalogRequest()->from()->shouldBe(30);
        $this->getCatalogRequest()->max()->shouldBe(15);
    }

    public function it_can_specify_blogs()
    {
        $this->fromBlogs('blog1')->shouldBe($this);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1']);
        $this->fromBlogs('blog2', 'blog3');
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
    }

    public function it_can_specify_blogs_as_array()
    {
        $this->fromBlogs(['blog1', 'blog2', 'blog3']);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
    }

    public function it_can_exclude_blogs()
    {
        $this->excludeBlogs('blog3')->shouldBe($this);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog3']);
        $this->excludeBlogs('blog4', 'blog5')->shouldBe($this);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog3', 'blog4', 'blog5']);
    }

    public function it_can_manage_include_exclude_blogs_collissions()
    {
        $this->fromBlogs('blog1', 'blog2', 'blog3', 'blog4');
        $this->excludeBlogs('blog2', 'blog1', 'blog5');
        $this->getCatalogRequest()->blogs()->shouldBe(['blog3', 'blog4']);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog5']);

    }

    public function it_can_manage_include_exclude_blogs_with_no_collissions()
    {
        $this->fromBlogs('blog1', 'blog2', 'blog3');
        $this->excludeBlogs('blog4', 'blog5');
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog4', 'blog5']);

    }

    public function it_can_specify_a_site(SiteService $siteService)
    {
        $siteService->getBlogs('site')->shouldBeCalled()->willReturn(['blog1', 'blog2', 'blog3']);
        $this->fromSite('site')->shouldBe($this);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
    }


    public function it_manages_featured_flag_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();
        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->onlyFeatured()->shouldBe(true);
    }

    private function getFullFixtureQuery()
    {
        return new ParameterBag(
            [
                'featured' => true,
                'public' => true,
                'home' => false,
                'blogs' => [
                    'blog1',
                    'blog2',
                ],
                'excludeBlogs' => [
                    'blog3',
                ],
            ]
        );
    }

    public function it_manages_public_flag_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->onlyPublic()->shouldBe(true);
    }

    public function it_manages_sticky_flag_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->ignoreSticky()->shouldBe(false);

    }


    public function it_manags_home_flag_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->onlyHome()->shouldBe(false);
    }

    public function it_manages_blogs_key_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);

        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2']);

    }

    public function it_manages_excluded_blogs_from_request_query(SiteService $siteService)
    {
        $query = $this->getFullFixtureQuery();

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog3']);

    }

    public function it_manages_site_key_from_request_query(SiteService $siteService)
    {
        $siteService->getBlogs('main')->shouldBeCalled()->willReturn(['blog1', 'blog2']);
        $query = new ParameterBag(
            [
                'site' => 'main',
            ]
        );

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2']);
    }


}
