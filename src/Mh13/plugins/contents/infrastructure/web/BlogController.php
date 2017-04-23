<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 12:10
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;


class BlogController
{
    public function view($slug, Application $app)
    {
        $blog = $app['blog.service']->getBlogWithSlug($slug);

        return $app['twig']->render(
            'plugins/contents/channels/view.twig',
            [
                'blog' => $blog,
                'tag' => false,
                'level_id' => false,
            ]
        );
    }

}
