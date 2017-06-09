<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 9/6/17
 * Time: 14:09
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;


class PageProvider implements ControllerProviderInterface
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
        $app['page.controller'] = function ($app) {
            return new PageController($app['twig']);
        };
        $pages = $app['controllers_factory'];
        $pages->get('/{page}', 'page.controller:view');

        return $pages;
    }
}
