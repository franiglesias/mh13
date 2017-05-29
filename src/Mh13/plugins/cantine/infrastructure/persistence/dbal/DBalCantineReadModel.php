<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/5/17
 * Time: 10:38
 */

namespace Mh13\plugins\cantine\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\cantine\application\CantineReadModel;


class DBalCantineReadModel implements CantineReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getTodayMeals(\DateTimeInterface $today)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('*')
            ->from('cantine_menu_dates', 'dates')
            ->leftJoin('dates', 'cantine_week_menus', 'week', 'dates.cantine_week_menu_id = week.id')
            ->leftJoin('week', 'cantine_day_menus', 'meals', 'meals.cantine_week_menu_id = week.id')
            ->where(':today between week.start and (week.start + interval 4 day)')
            ->andWhere('(dayofweek(:today) -1) = meaks.weekday')
            ->set('today', $today->format('Y-m-df'))
        ;
        $statement = $builder->execute();
        $result = $statement->fetch();

        return $result;
    }

    public function getWeekMeals()
    {
    }

    public function getMonthMeals()
    {
    }

}
