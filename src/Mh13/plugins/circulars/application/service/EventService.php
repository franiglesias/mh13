<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 9:37
 */

namespace Mh13\plugins\circulars\application\service;


use Mh13\plugins\circulars\application\readmodel\EventReadModel;


class EventService
{
    /**
     * @var EventReadModel
     */
    private $readModel;

    public function __construct(EventReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function getLastEvents()
    {
        return $this->readModel->findEvents('5');
    }

}
