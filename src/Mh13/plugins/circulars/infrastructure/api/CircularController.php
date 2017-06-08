<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:38
 */

namespace Mh13\plugins\circulars\infrastructure\api;


use League\Tactician\CommandBus;
use Mh13\plugins\circulars\application\circular\GetLastCirculars;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class CircularController
{


    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function last()
    {
        $command = new GetLastCirculars(5);
        $circulars = $this->bus->handle($command);
        if (!$circulars) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse($circulars, Response::HTTP_OK);
    }

}
