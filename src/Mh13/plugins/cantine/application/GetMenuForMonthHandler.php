<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 8/6/17
 * Time: 16:32
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForMonthHandler
{
    /**
     * @var CantineReadModel
     */
    private $readModel;

    public function __construct(CantineReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function handle(GetMenuForMonth $getMenuForMonth)
    {
        return $this->readModel->getMealsForMonth($getMenuForMonth->getMonth(), $getMenuForMonth->getYear());
    }
}
