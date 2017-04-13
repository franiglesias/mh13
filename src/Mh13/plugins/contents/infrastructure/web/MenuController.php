<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 13/4/17
 * Time: 13:04
 */

namespace Mh13\plugins\contents\infrastructure\web;


class MenuController
{
    public function menu($menuTitle, Application $app)
    {
        $menu = $app['menu.loader']->menuTitle($menuTitle);

        return $app['twig']->render(
            'plugins/menus/menu.twig',
            [
                'menu' => $menu,
            ]
        );
    }
}
