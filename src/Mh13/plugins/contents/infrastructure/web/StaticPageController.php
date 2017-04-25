<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 12:17
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;


class StaticPageController
{
    public function view($slug, Application $app)
    {
        $page = $app['staticpage.service']->getPageWithSlug($slug);

        return $app['twig']->render(
            'plugins/contents/static_pages/view.twig',
            [
                'page' => $page,
                'tag' => false,
                'level_id' => false,
                'preview' => false,
                'parents' => false,
                'siblings' => false,
                'descendants' => false,
            ]
        );
    }
}
