<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 9:28
 */

namespace Mh13\plugins\circulars\application\readmodel;


interface EventReadModel
{
    public function findEvents($maxCount);

    public function getEventOrFail($eventId);


}
