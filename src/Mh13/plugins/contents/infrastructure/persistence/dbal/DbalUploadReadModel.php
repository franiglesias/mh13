<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\UploadReadModel;


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

    public function findUploads($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('image.path', 'image.name', 'image.description')->from('uploads', 'image')->leftJoin(
                'image',
                'items',
                'article',
                'image.model = \'Item\' AND image.foreign_key = article.id'
            )->where($specification->getConditions())->setParameters(
                $specification->getParameters(),
                $specification->getTypes()
            )->orderBy('image.order', 'asc')
        ;
        $images = $builder->execute()->fetchAll();

        return $images;
    }
}
