<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\StaticPageReadModel;
use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;


class StaticPageService
{
    /**
     * @var StaticPageReadModel
     */
    private $readModel;
    /**
     * @var StaticPageSpecificationFactory
     */
    private $factory;

    public function __construct(StaticPageReadModel $readModel, StaticPageSpecificationFactory $factory)
    {
        $this->readModel = $readModel;
        $this->factory = $factory;
    }

    public function getPageWithSlug(string $slug)
    {
        $specification = $this->factory->createGetPageWithSlug($slug);

        return $this->readModel->getPage($specification);
    }

}
