<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 9:31
 */

namespace Mh13\plugins\circulars\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\circulars\application\readmodel\EventReadModel;


class DBalEventReadModel implements EventReadModel
{
    /**
     * @var Connection
     */
    private $connection;
    private $subQueryTemplate = '(select content from event_i18ns where event_i18ns.foreign_key = events.id and locale="%2$s" and field="%1$s" and model="Event") as %1$s';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
                'events.publish = 1 and ((events.endDate is null and events.startDate >= now() ) or events.endDate >= now() )'
            )
            ->orderBy(
                'startDate',
                'desc'
            )->addOrderBy(
                'startTime',
                'desc'
            )->setMaxResults($maxCount)
        ;
        $statement = $builder->execute();

        return $statement->fetchAll();
    }

    /**-
     * @param $field
     *
     * @param $locale
     *
     * @return string
     */
    protected function selectFieldFromTranslation($field, $locale): string
    {
        return sprintf($this->subQueryTemplate, $field, $locale);
    }

    public function getEventOrFail($eventId)
    {
    }
}
