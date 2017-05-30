<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/5/17
 * Time: 10:47
 */

namespace Mh13\plugins\cantine\application;

interface CantineReadModel
{
    public function getTodayMeals(\DateTimeInterface $today);

    public function getWeekMeals(\DateTimeInterface $today);

    public function getMonthMeals(\DateTimeInterface $today);
}
