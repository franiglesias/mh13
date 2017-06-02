<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:37
 */

namespace Mh13\plugins\circulars\application\service;


use Mh13\plugins\circulars\application\readmodel\CircularReadModel;


class CircularService
{
    /**
     * @var CircularReadModel
     */
    private $readModel;

    public function __construct(CircularReadModel $readModel)
    {

        $this->readModel = $readModel;
    }

    public function getLastCirculars()
    {
        return $this->readModel->findCirculars(5);
    }
}
