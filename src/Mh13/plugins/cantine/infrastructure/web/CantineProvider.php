<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 30/5/17
 * Time: 11:59
 */

namespace Mh13\plugins\cantine\infrastructure\web;


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
