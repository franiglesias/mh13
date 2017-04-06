<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 8:39
 */

namespace Mh13\plugins\access\services;


class Owned
{
    public $alias;
    public $id;

    /**
     * Owner constructor.
     *
     * @param $alias
     * @param $id
     */
    public function __construct($alias, $id)
    {
        $this->alias = $alias;
        $this->id = $id;
    }

}
