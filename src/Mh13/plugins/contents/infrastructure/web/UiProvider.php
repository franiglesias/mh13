<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 13/4/17
 * Time: 13:01
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;


class UiProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $ui = $app['controllers_factory'];
        $ui->get('/menu/{menuTitle}', MenuController::class."::menu");
        $ui->get('/menubar/{barTitle}/{type}', MenuController::class."::bar")->assert('type', 'menu|wide');
        return $ui;
    }
}
