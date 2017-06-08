<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 9:31
 */

namespace Mh13\plugins\circulars\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\circulars\application\event\EventReadModel;
use Mh13\shared\persistence\Multilingual;


class DBalEventReadModel implements EventReadModel
{
    use Multilingual;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->configureTranslations('events', 'Event', 'event_i18ns');
    }

    public function findEvents($maxCount = 5)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                $this->selectFieldFromTranslation('title', 'spa'),
                $this->selectFieldFromTranslation('description', 'spa'),
                $this->selectFieldFromTranslation('place', 'spa'),
                'events.*'
            )
            ->from(
                'events'
            )
            ->where(
                'events.publish = 1 and ((events.endDate is null and events.startDate >= CURDATE() ) or events.endDate >= CURDATE() )'
            )
            ->orderBy(
                'startDate',
                'asc'
            )->addOrderBy(
                'startTime',
                'asc'
            )->setMaxResults($maxCount)
        ;
        $statement = $builder->execute();

        return $statement->fetchAll();
    }

}
