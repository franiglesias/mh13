<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Silex\Application;
use Symfony\Component\HttpFoundation\Response;


class ArticleController
{
    /**
     * Returns a view of the selected articles
     */
    public function catalog()
    {

    }

    /**
     * Shows a view for the article specified by a slug
     *
     * @param string      $slug
     * @param Application $app
     *
     * @return string
     */
    public function view($slug, Application $app)
    {
        try {
            // Get ArticleService
            // Send request to article service
            // Generate View
            return $app['twig']->render('plugins/contents/items/view.twig', [/* data */]);
        } catch (\Exception $exception) {
        }

        return Response::create('Solicitaste el artículo: '.$slug);

    }
}
