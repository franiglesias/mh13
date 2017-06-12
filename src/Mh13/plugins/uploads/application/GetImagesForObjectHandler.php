<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\uploads\application;


use Mh13\plugins\contents\application\service\upload\UploadContextFactory;
use Mh13\plugins\contents\domain\UploadSpecificationFactory;


class GetImagesForObjectHandler
{
    /**
     * @var UploadReadModel
     */
    private $readModel;
    /**
     * @var UploadSpecificationFactory
     */
    private $factory;
    /**
     * @var UploadContextFactory
     */
    private $contextFactory;

    public function __construct(
        UploadReadModel $readModel,
        UploadSpecificationFactory $factory,
        UploadContextFactory $contextFactory
    ) {

        $this->readModel = $readModel;
        $this->factory = $factory;
        $this->contextFactory = $contextFactory;
    }

    public function handle(GetImagesForObject $getImagesForObject)
    {
        $context = $this->contextFactory->getContextFor($getImagesForObject->getObject());
        $specification = $this->factory->createAttachedImages($context, $getImagesForObject->getAlias());

        return $this->readModel->findUploads($specification, $context);
    }


}
