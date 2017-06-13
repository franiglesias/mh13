<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\uploads\application;


use Mh13\plugins\contents\domain\UploadSpecificationFactory;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContextFactory;


class GetDownloadsForObjectHandler
{
    /**
     * @var \Mh13\plugins\uploads\application\UploadReadModel
     */
    private $readModel;
    /**
     * @var UploadSpecificationFactory
     */
    private $factory;
    /**
     * @var \Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContextFactory
     */
    private $contextFactory;

    public function __construct(
        UploadReadModel $readModel,
        UploadSpecificationFactory $factory,
        DBalUploadContextFactory $contextFactory
    ) {

        $this->readModel = $readModel;
        $this->factory = $factory;
        $this->contextFactory = $contextFactory;
    }

    public function handle(GetDownloadsForObject $getDownloadsForObject)
    {
        $context = $this->contextFactory->getContextFor($getDownloadsForObject->getObject());
        $specification = $this->factory->createAttachedDownloads($context, $getDownloadsForObject->getAlias());

        return $this->readModel->findUploads($specification, $context);
    }


}
