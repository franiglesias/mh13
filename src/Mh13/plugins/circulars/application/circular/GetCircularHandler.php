<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:37
 */

namespace Mh13\plugins\circulars\application\circular;


class GetCircularHandler
{
    /**
     * @var \Mh13\plugins\circulars\application\circular\CircularReadModel
     */
    private $readModel;

    public function __construct(CircularReadModel $readModel)
    {

        $this->readModel = $readModel;
    }

    public function handle(GetCircular $getCircular)
    {
        return $this->readModel->getByIdOrFail($getCircular->getId());
    }
}
