<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\service;


use Mh13\plugins\contents\application\readmodel\UploadReadModel;
use Mh13\plugins\contents\application\service\upload\UploadContextFactory;
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
    /**
     * @var UploadContextFactory
     */
    private $contextFactory;

    public function __construct(
        UploadReadModel $readModel,
        UploadSpecificationFactory $factory,
        UploadContextFactory $contextFactory
    )
    {

        $this->readModel = $readModel;
        $this->factory = $factory;
        $this->contextFactory = $contextFactory;
    }

    public function getImagesOf(string $object, string $slug)
    {
        $context = $this->contextFactory->getContextFor($object);
        $specification = $this->factory->createAttachedImages($context, $slug);

        return $this->readModel->findUploads($specification, $context);
    }

    public function getDownloadsOf(string $object, string $slug)
    {
        $context = $this->contextFactory->getContextFor($object);
        $specification = $this->factory->createAttachedDownloads($context, $slug);

        return $this->readModel->findUploads($specification, $context);
    }

    public function getMediaOf(string $object, string $slug)
    {
        $context = $this->contextFactory->getContextFor($object);
        $specification = $this->factory->createAttachedMedia($context, $slug);

        return $this->readModel->findUploads($specification, $context);
    }

}
