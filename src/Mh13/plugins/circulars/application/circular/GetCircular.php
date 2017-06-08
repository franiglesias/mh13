<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:37
 */

namespace Mh13\plugins\circulars\application\circular;


class GetCircular
{
    private $id;

    public function __construct($id)
    {

        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}
