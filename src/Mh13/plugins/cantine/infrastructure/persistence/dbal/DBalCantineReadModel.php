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

    public function getMealsForDay(\DateTimeInterface $today)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('*')
            ->from('cantine_menu_dates', 'dates')
            ->leftJoin('dates', 'cantine_week_menus', 'week', 'dates.cantine_week_menu_id = week.id')
            ->leftJoin('week', 'cantine_day_menus', 'meals', 'meals.cantine_week_menu_id = week.id')
            ->where(':today between dates.start and (dates.start + interval 4 day)')
            ->andWhere('(dayofweek(:today) -1) = meals.weekday')
            ->setParameter('today', $today->format('Y-m-d'))
        ;
        $statement = $builder->execute();
        $result = $statement->fetch();

        return $result;
    }

    public function getMealsForWeek($weekNumber, $year)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('*')
            ->from('cantine_menu_dates', 'dates')
            ->leftJoin('dates', 'cantine_week_menus', 'week', 'dates.cantine_week_menu_id = week.id')
            ->leftJoin('week', 'cantine_day_menus', 'meals', 'meals.cantine_week_menu_id = week.id')
            ->where('week(dates.start, 1) = :week and year(dates.start) = :year')
            ->orderBy('meals.weekday', 'asc')
            ->setParameter('week', $weekNumber)
            ->setParameter('year', $year)
        ;
        $statement = $builder->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    public function getMealsForMonth(\DateTimeInterface $today)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('*')
            ->from('cantine_menu_dates', 'dates')
            ->leftJoin('dates', 'cantine_week_menus', 'week', 'dates.cantine_week_menu_id = week.id')
            ->leftJoin('week', 'cantine_day_menus', 'meals', 'meals.cantine_week_menu_id = week.id')
            ->where('month(:today) = month(dates.start) and year(:today) = year(dates.start)')
            ->orderBy('dates.start', 'asc')
            ->addOrderBy('meals.weekday', 'asc')
            ->setParameter('today', $today->format('Y-m-d'))
        ;
        $statement = $builder->execute();
        $result = $statement->fetchAll();

        return $result;
    }

}
