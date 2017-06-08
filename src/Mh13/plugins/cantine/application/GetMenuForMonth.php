<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 8/6/17
 * Time: 16:31
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForMonth
{
    private $month;
    private $year;

    public function __construct($month, $year)
    {

        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }


}
