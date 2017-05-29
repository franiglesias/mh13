<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/5/17
 * Time: 12:52
 */

namespace Mh13\plugins\cantine\infrastructure\web;


use Mh13\plugins\cantine\application\CantineReadModel;


class CanteenController
{
    /**
     * @var CantineReadModel
     */
    private $readModel;

    public function __construct(CantineReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function today()
    {
        $today = new \DateTimeImmutable();
        $result = $this->readModel->getTodayMeals($today);

        return $result;
    }

    public function week()
    {
        $today = new \DateTimeImmutable('2017/03/27');
        $result = $this->readModel->getWeekMeals($today);

        return json_encode($result);
    }
}
