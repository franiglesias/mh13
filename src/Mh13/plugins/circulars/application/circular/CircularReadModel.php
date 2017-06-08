<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 14:23
 */

namespace Mh13\plugins\circulars\application\circular;


interface CircularReadModel
{
    public function findCirculars($maxCount);

    public function getByIdOrFail($id);

}
