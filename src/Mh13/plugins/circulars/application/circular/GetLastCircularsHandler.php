<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 8/6/17
 * Time: 9:56
 */

namespace Mh13\plugins\circulars\application\circular;


class GetLastCircularsHandler
{
    const NUMBER_OF_CIRCULARS = 5;
    /**
     * @var CircularReadModel
     */
    private $readModel;

    public function __construct(CircularReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    public function handle(GetLastCirculars $getLastCirculars)
    {
        return $this->readModel->findCirculars($getLastCirculars->getMaxNumber());
    }

}

