<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 13:54
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForWeekHandler
{
    /**
     * @var CantineReadModel
     */
    private $readModel;

    public function __construct(CantineReadModel $readModel)
    {

        $this->readModel = $readModel;
    }

    public function handle(GetMenuForWeek $getMenuForWeek)
    {
        return $this->readModel->getMealsForWeek($getMenuForWeek->getWeekNumber(), $getMenuForWeek->getYear());
    }
}
