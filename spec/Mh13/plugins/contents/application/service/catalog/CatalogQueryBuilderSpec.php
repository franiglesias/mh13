<?php

namespace spec\Mh13\plugins\contents\application\service\catalog;

use Mh13\plugins\contents\application\service\catalog\CatalogQueryBuilder;
use Mh13\plugins\contents\application\service\catalog\SiteService;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;


class CatalogQueryBuilderSpec extends ObjectBehavior
{

    public function let(SiteService $siteService)
    {
        $this->beConstructedWith($siteService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CatalogQueryBuilder::class);
    }

    public function it_can_restrict_to_home_only()
    {
        $this->onlyHome()->shouldBe($this);
        $this->shouldBeRestrictedToHome();
        $this->getCatalogRequest()->onlyHome()->shouldBe(true);
    }

    public function it_can_restrict_to_featured_only()
    {
        $this->onlyFeatured()->shouldBe($this);
        $this->shouldBeRestrictedToFeatured();
        $this->getCatalogRequest()->onlyFeatured()->shouldBe(true);
    }

    public function it_can_restrict_to_public_only()
    {
        $this->onlyPublic()->shouldBe($this);
        $this->shouldBeRestrictedToPublic();
        $this->getCatalogRequest()->onlyPublic()->shouldBe(true);
    }

    public function it_can_allow_public_and_private()
    {
        $this->allowPrivate()->shouldBe($this);
        $this->shouldNotBeRestrictedToPublic();
        $this->getCatalogRequest()->onlyPublic()->shouldBe(false);
    }

    public function it_has_restrictions_by_default()
    {
        $this->shouldNotBeRestrictedToHome();
        $this->shouldNotBeRestrictedToFeatured();
        $this->shouldBeRestrictedToPublic();
        $this->getCatalogRequest()->onlyFeatured()->shouldBe(false);
        $this->getCatalogRequest()->onlyHome()->shouldBe(false);
        $this->getCatalogRequest()->onlyPublic()->shouldBe(true);
    }

    public function it_can_restrict_to_page()
    {
        $this->page(3)->shouldBe($this);
        $this->getPage()->shouldBe(3);
        $this->getCatalogRequest()->from()->shouldBe(31);
        $this->getCatalogRequest()->max()->shouldBe(15);
    }

    public function it_can_specify_blogs()
    {
        $this->fromBlogs('blog1')->shouldBe($this);
        $this->getBlogs()->shouldBe(['blog1']);
        $this->fromBlogs('blog2', 'blog3');
        $this->getBlogs()->shouldBe(['blog1', 'blog2', 'blog3']);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
    }

    public function it_can_exclude_blogs()
    {
        $this->excludeBlogs('blog3')->shouldBe($this);
        $this->getExcludedBlogs()->shouldBe(['blog3']);
        $this->excludeBlogs('blog4', 'blog5')->shouldBe($this);
        $this->getExcludedBlogs()->shouldBe(['blog3', 'blog4', 'blog5']);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog3', 'blog4', 'blog5']);
    }

    public function it_can_manage_include_exclude_blogs_collissions()
    {
        $this->fromBlogs('blog1', 'blog2', 'blog3', 'blog4');
        $this->excludeBlogs('blog2', 'blog1', 'blog5');
        $this->getBlogs()->shouldBeLike(['blog3', 'blog4']);
        $this->getExcludedBlogs()->shouldBeLike(['blog5']);

        $this->getCatalogRequest()->blogs()->shouldBe(['blog3', 'blog4']);
        $this->getCatalogRequest()->excludedBlogs()->shouldBe(['blog5']);

    }

    public function it_can_specify_a_site(SiteService $siteService)
    {
        $siteService->getBlogs('site')->shouldBeCalled()->willReturn(['blog1', 'blog2', 'blog3']);
        $this->fromSite('site')->shouldBe($this);
        $this->getBlogs(['blog1', 'blog2', 'blog3']);
        $this->getCatalogRequest()->blogs()->shouldBe(['blog1', 'blog2', 'blog3']);
    }

    public function it_can_be_constructed_from_request_query(SiteService $siteService)
    {
        $query = new ParameterBag(
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

        $this->beConstructedThrough('fromQuery', [$query, $siteService]);

        $this->shouldBeRestrictedToFeatured();
        $this->shouldBeRestrictedToPublic();
        $this->shouldNotBeRestrictedToHome();
        $this->getBlogs()->shouldBe(['blog1', 'blog2']);
        $this->getExcludedBlogs()->shouldBe(['blog3']);

    }


}
