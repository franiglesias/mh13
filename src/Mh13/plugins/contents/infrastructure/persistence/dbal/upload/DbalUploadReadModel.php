<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\upload;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\upload\UploadContext;
use Mh13\plugins\uploads\application\UploadReadModel;


class DbalUploadReadModel implements UploadReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function findUploads($specification, UploadContext $context)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select(
            [
                'upload.path',
                'upload.name',
                'upload.description',
                'upload.url',
                'upload.size',
                'upload.type',
                'upload.playtime',
            ]
        )->from('uploads', 'upload')->leftJoin(
            'upload',
            $context->getTable(),
            $context->getAlias(),
            'upload.model = :model AND upload.foreign_key = '.$context->getAlias().'.id'
        )->where($specification->getConditions())->setParameters(
                $specification->getParameters(),
                $specification->getTypes()
        )->setParameter('model', $context->getModel())->orderBy('upload.order', 'asc')
        ;
        $uploads = $builder->execute()->fetchAll();

        return $uploads;
    }
}
