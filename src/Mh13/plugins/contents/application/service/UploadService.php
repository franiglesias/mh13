<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\UploadReadModel;
use Mh13\plugins\contents\domain\UploadSpecificationFactory;


class UploadService
{
    /**
     * @var UploadReadModel
     */
    private $readModel;
    /**
     * @var UploadSpecificationFactory
     */
    private $factory;

    public function __construct(UploadReadModel $readModel, UploadSpecificationFactory $factory)
    {

        $this->readModel = $readModel;
        $this->factory = $factory;
    }

    public function getImagesOfArticle(string $slug)
    {
        $specification = $this->factory->createImagesOfArticle($slug);

        return $this->readModel->findUploads($specification);

    }
}
