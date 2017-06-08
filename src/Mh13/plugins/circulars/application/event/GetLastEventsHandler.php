<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 9:37
 */

namespace Mh13\plugins\circulars\application\event;


class GetLastEventsHandler
{
    /**
     * @var EventReadModel
     */
    private $readModel;

    public function __construct(EventReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function handle(GetLastEvents $getLastEvent)
    {
        return $this->readModel->findEvents($getLastEvent->getMaxNumber());
    }

}
