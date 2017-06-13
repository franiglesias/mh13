<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 13/4/17
 * Time: 13:01
 */

namespace Mh13\shared\web\ui;


use Mh13\plugins\contents\infrastructure\web\MenuController;
use Mh13\shared\web\menus\MenuBarLoader;
use Mh13\shared\web\menus\MenuLoader;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;


class UiProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /* Service definitions */

        $app['menu.loader'] = function ($app) {
            return new MenuLoader($app['config.path'].'menus.yml');
        };

        $app['bar.loader'] = function ($app) {
            return new MenuBarLoader($app['config.path'].'menus.yml');
        };

        $ui = $app['controllers_factory'];
        $ui->get('/menu/{menuTitle}', MenuController::class."::menu");
        $ui->get('/menubar/{barTitle}/{type}', MenuController::class."::bar")->assert('type', 'menu|wide');

        return $ui;
    }
}
