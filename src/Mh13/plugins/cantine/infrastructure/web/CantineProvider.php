<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 30/5/17
 * Time: 11:59
 */

namespace Mh13\plugins\cantine\infrastructure\web;


use Mh13\plugins\cantine\application\GetMenuForDay;
use Mh13\plugins\cantine\application\GetMenuForDayHandler;
use Mh13\plugins\cantine\application\GetMenuForMonth;
use Mh13\plugins\cantine\application\GetMenuForMonthHandler;
use Mh13\plugins\cantine\application\GetMenuForWeek;
use Mh13\plugins\cantine\application\GetMenuForWeekHandler;
use Mh13\plugins\cantine\infrastructure\persistence\dbal\DBalCantineReadModel;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class CantineProvider implements ControllerProviderInterface
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
        $app['cantine.readmodel'] = function ($app) {
            return new DBalCantineReadModel($app['db']);
        };

        $app['cantine.controller'] = function ($app) {
            return new CantineController($app['command.bus'], $app['twig']);
        };

        $app[GetMenuForDayHandler::class] = function ($app) {
            return new GetMenuForDayHandler($app['cantine.readmodel']);
        };

        $app[GetMenuForWeekHandler::class] = function ($app) {
            return new GetMenuForWeekHandler($app['cantine.readmodel']);
        };

        $app[GetMenuForMonthHandler::class] = function ($app) {
            return new GetMenuForMonthHandler($app['cantine.readmodel']);
        };

        $app['command.bus.locator']->addHandler($app[GetMenuForDayHandler::class], GetMenuForDay::class);
        $app['command.bus.locator']->addHandler($app[GetMenuForWeekHandler::class], GetMenuForWeek::class);
        $app['command.bus.locator']->addHandler($app[GetMenuForMonthHandler::class], GetMenuForMonth::class);

        $cantine = $app['controllers_factory'];
        $cantine->get('/today', "cantine.controller:today");
        $cantine->get('/week', "cantine.controller:week");
        $cantine->get('/month', "cantine.controller:month");
        $cantine->get(
            '/',
            function () use ($app) {
                return $app['twig']->render('plugins/cantine/home.twig');
            }
        );

        return $cantine;
    }
}
