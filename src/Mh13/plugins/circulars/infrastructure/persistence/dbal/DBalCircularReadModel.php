<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 14:24
 */

namespace Mh13\plugins\circulars\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\circulars\application\readmodel\CircularReadModel;
use Mh13\shared\persistence\Multilingual;


class DBalCircularReadModel implements CircularReadModel
{

    use Multilingual;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
        $this->configureTranslations('circulars', 'Circular', 'circular_i18ns');

    }

    public function findCirculars($maxCount)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                $this->selectFieldFromTranslation('title', 'spa'),
                $this->selectFieldFromTranslation('content', 'spa'),
                $this->selectFieldFromTranslation('extra', 'spa'),
                $this->selectFieldFromTranslation('signature', 'spa'),
                $this->selectFieldFromTranslation('addressee', 'spa'),
                'circulars.*'
            )
            ->from(
                'circulars'
            )
            ->where(
                'circulars.status = 2'
            )
            ->orderBy(
                'pubDate',
                'desc'
            )->setMaxResults($maxCount)
        ;
        $statement = $builder->execute();

        return $statement->fetchAll();
    }

}
