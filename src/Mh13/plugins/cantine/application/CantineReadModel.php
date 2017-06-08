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
    public function getMealsForDay(\DateTimeInterface $today);

    public function getMealsForWeek($weekNumber, $year);

    public function getMealsForMonth($month, $year);
}
