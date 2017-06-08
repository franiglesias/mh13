<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 1/6/17
 * Time: 11:12
 */

namespace Mh13\plugins\circulars\infrastructure\web;

use League\Tactician\CommandBus;
use Mh13\plugins\circulars\application\event\GetLastEvents;


class EventController
{
    /**
     * @var CommandBus
     */
    private $bus;
    private $templating;

    public function __construct(CommandBus $bus, $templating)
    {
        $this->bus = $bus;
        $this->templating = $templating;
    }

    public function last()
    {
        $events = $this->bus->handle(new GetLastEvents(5));

        return $this->templating->render(
            'plugins/circulars/nextevents.twig',
            [
                'events' => $events,
            ]
        );
    }
}
