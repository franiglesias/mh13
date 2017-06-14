<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 13:30
 */

namespace Mh13\plugins\circulars\infrastructure\web;


use Mh13\plugins\circulars\application\event\GetLastEventsHandler;
use Mh13\plugins\circulars\infrastructure\persistence\dbal\DBalEventReadModel;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class EventProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $app['event.readmodel'] = function ($app) {
            return new DBalEventReadModel($app['db']);
        };

        $app['event.controller'] = function () use ($app) {
            return new EventController($app['command.bus'], $app['twig']);
        };

        $app[GetLastEventsHandler::class] = function ($app) {
            return new GetLastEventsHandler($app['event.readmodel']);
        };

        $events = $app['controllers_factory'];
        $events->get('/last', 'event.controller:last');

        return $events;
    }
}
