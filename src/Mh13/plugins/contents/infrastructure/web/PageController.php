<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 12:55
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;


class PageController
{
    public function view($page, Application $app)
    {
        return $app['twig']->render('pages/'.$page.'.twig');
    }
}
