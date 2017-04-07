<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\GetArticleBySlugRequest;
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
            $request = new GetArticleBySlugRequest($slug);
            $article = $app['get-article-by-slug.service']->execute($request);

            return $app['twig']->render(
                'plugins/contents/items/view.twig',
                [
                    'article' => $article,
                ]
            );
        } catch (\Exception $exception) {
            return Response::create('Algún problema ha habido con el artículo: '.$exception->getMessage());
        }

        return Response::create('Solicitaste el artículo: '.$slug);

    }
}
