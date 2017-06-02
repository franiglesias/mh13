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


class DBalCircularReadModel implements CircularReadModel
{


    /**
     * @var Connection
     */
    private $connection;
    private $subQueryTemplate = '(select content from circular_i18ns where circular_i18ns.foreign_key = circulars.id and locale="%2$s" and field="%1$s" and model="Circular") as %1$s';

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
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
}
