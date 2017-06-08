<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 12:39
 */

namespace Mh13\plugins\circulars\application\event;


class GetLastEvents
{
    const MAX_NUMBER = 5;
    /**
     * @var null
     */
    private $maxNumber;

    public function __construct($maxNumber = null)
    {
        $this->maxNumber = $maxNumber ? $maxNumber : self::MAX_NUMBER;
    }

    /**
     * @return null
     */
    public function getMaxNumber()
    {
        return $this->maxNumber;
    }
}
