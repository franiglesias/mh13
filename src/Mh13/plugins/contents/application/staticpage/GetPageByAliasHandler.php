<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\staticpage;


use Mh13\plugins\contents\application\readmodel\StaticPageReadModel;
use Mh13\plugins\contents\domain\StaticPageRelatedFinderFactory;
use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;


class GetPageByAliasHandler
{
    /**
     * @var StaticPageReadModel
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
    ) {
        $this->readModel = $readModel;
        $this->factory = $factory;
        $this->relatedQueryFactory = $relatedQueryFactory;
    }

    public function handle(GetPageByAlias $getPageByAlias)
    {
        $alias = $getPageByAlias->getAlias();
        $specification = $this->factory->createGetPageWithSlug($alias);
        $data = [
            'page'        => $this->readModel->getPage($specification),
            'parents'     => $this->getParentsForPage($alias),
            'descendants' => $this->getDescendantsForPage($alias),
            'siblings'    => $this->getSiblingsForPage($alias),
        ];

        return $data;
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
