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
        $parameters = $specification->getParameters();
        $builder = $this->connection->createQueryBuilder();
        $builder->select('image.path', 'image.name', 'image.description', 'image.url')
            ->from('uploads', 'image')
            ->leftJoin(
                'image',
                $parameters['table'],
                'article',
                'image.model = :model AND image.foreign_key = article.id'
            )->where($specification->getConditions())->setParameters(
                $specification->getParameters(),
                $specification->getTypes()
            )->orderBy('image.order', 'asc')
        ;
        $images = $builder->execute()->fetchAll();

        return $images;
    }
}
