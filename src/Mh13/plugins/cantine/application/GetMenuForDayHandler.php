<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 12:57
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForDayHandler
{
    /**
     * @var CantineReadModel
     */
    private $readModel;

    public function __construct(CantineReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function handle(GetMenuForDay $getMenuForDay)
    {
        return $this->readModel->getMealsForDay($getMenuForDay->getDate());
    }
}
