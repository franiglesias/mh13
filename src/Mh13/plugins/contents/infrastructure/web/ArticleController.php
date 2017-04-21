<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\catalog\CatalogRequestBuilder;
use Mh13\plugins\contents\application\service\GetArticleRequest;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class ArticleController
{
    /**
     * Returns a selection of articles
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return
     */
    public function catalog(Request $request, Application $app)
    {
        $catalogRequest = CatalogRequestBuilder::fromQuery($request->query, $app['site.service'])->getCatalogRequest();
        $articles = $app['catalog.service']->getArticles($catalogRequest);

        return $app['twig']->render(
            'plugins/contents/items/catalog.twig',
            [
                'articles' => $articles,
                'layout' => $request->query->get('layout', 'feed'),
            ]
        );
    }

    /**
     * Shows a view for the article specified by a sl
     *  
     * @param string      $slug
     * @param Application $app
     *
     * @return string
     */
    public function view($slug, Application $app)
    {

        $article = $app['article.service']->getArticle($slug);
        $blog = $app['blog.service']->getBlog($article['blog_slug']);
        return $app['twig']->render(
            'plugins/contents/items/view.twig',
            [
                'article' => $article,
                'blog' => $blog,
                'image' => $article['image'],
                'preview' => false,
            ]
        );
    }
}
