<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 13:52
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForWeek
{
    private $weekNumber;
    private $year;

    public function __construct($weekNumber, $year)
    {
        $this->weekNumber = $weekNumber;
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getWeekNumber()
    {
        return $this->weekNumber;
    }


    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }


}
