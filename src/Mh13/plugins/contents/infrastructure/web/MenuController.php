<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 13/4/17
 * Time: 13:04
 */

namespace Mh13\plugins\contents\infrastructure\web;

use Silex\Application;


class MenuController
{
    public function menu($menuTitle, Application $app)
    {
        $menu = $app['menu.loader']->load($menuTitle);

        return $app['twig']->render(
            'plugins/menus/menu.twig',
            [
                'menu' => $menu,
            ]
        );
    }

    public function bar($barTitle, $type, Application $app)
    {
        $bar = $app['bar.loader']->load($barTitle);

        return $app['twig']->render(
            'plugins/menus/bars/'.$type.'bar.twig',
            [
                'bar' => $bar,
            ]
        );

    }
}
