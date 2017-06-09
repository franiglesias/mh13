<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 9:36
 */

namespace Mh13\plugins\circulars\infrastructure\web;


use Mh13\plugins\circulars\application\circular\GetCircular;
use Mh13\plugins\circulars\application\circular\GetCircularHandler;
use Mh13\plugins\circulars\application\circular\GetLastCirculars;
use Mh13\plugins\circulars\application\circular\GetLastCircularsHandler;
use Mh13\plugins\circulars\infrastructure\persistence\dbal\DBalCircularReadModel;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class CircularProvider implements ControllerProviderInterface
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

        $app['circular.readmodel'] = function ($app) {
            return new DBalCircularReadModel($app['db']);
        };


        $app['circular.controller'] = function ($app) {
            return new CircularController($app['command.bus'], $app['twig']);
        };


        $app[GetLastCircularsHandler::class] = function ($app) {
            return new GetLastCircularsHandler($app['circular.readmodel']);
        };

        $app[GetCircularHandler::class] = function ($app) {
            return new GetCircularHandler($app['circular.readmodel']);
        };

        $app['command.bus.locator']->addHandler($app[GetLastCircularsHandler::class], GetLastCirculars::class);
        $app['command.bus.locator']->addHandler($app[GetCircularHandler::class], GetCircular::class);

        $circulars = $app['controllers_factory'];
        $circulars->get('/last', "circular.controller:last");
        $circulars->get('/view/{id}', "circular.controller:view");

        return $circulars;
    }
}
