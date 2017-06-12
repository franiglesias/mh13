<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\staticpage\StaticPageReadModel;
use Mh13\plugins\contents\domain\StaticPageRelatedFinderFactory;
use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;


class StaticPageService
{
    /**
     * @var \Mh13\plugins\contents\application\staticpage\StaticPageReadModel
     */
    private $readModel;
    /**
     * @var StaticPageSpecificationFactory
     */
    private $factory;
    /**
     * @var StaticPageRelatedFinderFactory
     */
    private $relatedQueryFactory;

    public function __construct(
        StaticPageReadModel $readModel,
        StaticPageSpecificationFactory $factory,
        StaticPageRelatedFinderFactory $relatedQueryFactory
    )
    {
        $this->readModel = $readModel;
        $this->factory = $factory;
        $this->relatedQueryFactory = $relatedQueryFactory;
    }

    public function getPageWithSlug(string $slug)
    {
        $specification = $this->factory->createGetPageWithSlug($slug);

        return $this->readModel->getPage($specification);
    }

    public function getParentsForPage(string $slug)
    {
        $specification = $this->relatedQueryFactory->createFindParentsForPageWithSlug($slug);

        return $this->readModel->findPages($specification);
    }

    public function getDescendantsForPage(string $slug)
    {
        $specification = $this->relatedQueryFactory->createFindDescendantsWithDepthForPageWithSlug($slug);
        $data = $this->readModel->findPages($specification);

        return $data;
    }

    public function getSiblingsForPage(string $slug)
    {
        $specification = $this->relatedQueryFactory->createFindSiblingsForPageWithSlug($slug);
        $data = $this->readModel->findPages($specification);

        return $data;
    }


}
