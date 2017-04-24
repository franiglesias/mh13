<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 11:52
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;


class SiteController
{
    public function view($slug, Application $app)
    {
        $site = $app['site.service']->getWithSlug($slug);

        return $app['twig']->render(
            'plugins/contents/sites/view.twig',
            [
                'site' => $site,
            ]

        );
    }
}
