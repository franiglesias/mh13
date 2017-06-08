<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 12:56
 */

namespace Mh13\plugins\cantine\application;


class GetMenuForDay
{
    /**
     * @var \DateTimeInterface
     */
    private $date;

    public function __construct(\DateTimeInterface $date)
    {

        $this->date = $date;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }
}
