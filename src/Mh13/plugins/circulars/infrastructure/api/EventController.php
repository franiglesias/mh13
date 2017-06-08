<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 11:12
 */

namespace Mh13\plugins\circulars\infrastructure\api;


use League\Tactician\CommandBus;
use Mh13\plugins\circulars\application\event\GetLastEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class EventController
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
        $events = $this->bus->handle(new GetLastEvents(5));
        if (!$events) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse($events, Response::HTTP_OK);
    }
}
