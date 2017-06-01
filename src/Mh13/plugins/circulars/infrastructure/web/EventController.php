<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 11:12
 */

namespace Mh13\plugins\circulars\infrastructure\web;


use Mh13\plugins\circulars\application\service\EventService;


class EventController
{
    /**
     * @var EventService
     */
    private $eventService;
    private $templating;

    public function __construct(EventService $eventService, $templating)
    {
        $this->eventService = $eventService;
        $this->templating = $templating;
    }

    public function last()
    {
        $events = $this->eventService->getLastEvents();

        return $this->templating->render(
            'plugins/circulars/nextevents.twig',
            [
                'events' => $events,
            ]
        );
    }
}
