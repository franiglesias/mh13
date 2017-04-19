<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\catalog\CatalogQueryBuilder;
use Mh13\plugins\contents\application\service\GetArticleRequest;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController
{
    /**
     * Returns a view of the selected articles
     */
    public function catalog(Request $request, Application $app)
    {
        $catalogRequest = CatalogQueryBuilder::fromQuery($request->query, $app['site.service'])->getCatalogRequest();
        $articles = $app['catalog.service']->getArticles($catalogRequest);

        return $app['twig']->render(
            'plugins/contents/items/catalog.twig',
            [
                'articles' => $articles,
                'layout' => 'feed',
            ]
        );
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
            $id = $app['item.slug.converter']->mapToId($slug);
            $request = new GetArticleRequest($id);
            $article = $app['get_article.service']->execute($request);

            return $app['twig']->render(
                'plugins/contents/items/view.twig',
                [
                    'article' => $article,
                    'slug' => $slug,
                ]
            );
        } catch (\Exception $exception) {
            return Response::create('Ha habido un problema con el artículo: '.$exception->getMessage());
        }

        return Response::create('Solicitaste el artículo: '.$slug);

    }
}
