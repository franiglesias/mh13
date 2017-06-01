<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 11:12
 */

namespace Mh13\plugins\circulars\infrastructure\api;


use Mh13\plugins\circulars\application\service\EventService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class EventController
{
    /**
     * @var EventService
     */
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function last()
    {
        $events = $this->eventService->getLastEvents();
        if (!$events) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse($events, Response::HTTP_OK);
    }
}
