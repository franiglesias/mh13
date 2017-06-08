<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 9:56
 */

namespace Mh13\plugins\circulars\application\circular;


class GetLastCirculars
{
    const NUMBER_OF_CIRCULARS = 5;
    /**
     * @var null
     */
    private $maxNumber;

    public function __construct($maxNumber = null)
    {
        $this->maxNumber = $maxNumber ? $maxNumber : self::NUMBER_OF_CIRCULARS;
    }

    /**
     * @return int
     */
    public function getMaxNumber()
    {
        return $this->maxNumber;
    }


}

