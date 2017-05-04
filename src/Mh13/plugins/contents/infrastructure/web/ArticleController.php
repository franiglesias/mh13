<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\article\ArticleRequestBuilder;
use Mh13\plugins\contents\application\service\GetArticleRequest;
use Mh13\plugins\contents\infrastructure\persistence\dbal\model\article\ArticleListView;
use Mh13\plugins\contents\infrastructure\persistence\dbal\model\article\FullArticleView;
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
        $articleRequest = ArticleRequestBuilder::fromQuery($request->query, $app['site.service'])->getCatalogRequest();
        $articles = $app['article.service']->getArticlesFromRequest($articleRequest);

        return $app['twig']->render(
            'plugins/contents/items/catalog.twig',
            [
                'articles' => array_map(
                    function ($article) {
                        return ArticleListView::fromArray($article);
                    },
                    $articles
                ),
                'layout' => $request->query->get('layout', 'feed'),
            ]
        );
    }

    public function feed(Request $request, Application $app)
    {
        $articleRequest = ArticleRequestBuilder::fromQuery($request->query, $app['site.service'])->getCatalogRequest();
        $articles = $app['article.service']->getArticlesFromRequest($articleRequest);
        $total = $app['article.service']->getArticlesCountForRequest($articleRequest);

        $maxPages = ceil($total / $articleRequest->max());

        if (!$articles) {
            $error = ['code' => 204, 'message' => 'No articles found for this query.'];

            return $app->json($error, 204);
        }
        $url = $request->getUri();
        $first = preg_replace('/page\=\d+/', 'page=1', $url);
        $prev = preg_replace_callback(
            '/page\=\d+/',
            function ($page) {
                list(, $number) = explode('=', $page[0]);
                if ($number > 1) {
                    return 'page='.($number - 1);
                }

                return $page[0];
            },
            $url
        );
        $next = preg_replace_callback(
            '/page\=\d+/',
            function ($page) use ($maxPages) {
                list(, $number) = explode('=', $page[0]);
                if ($number < $maxPages) {
                    return 'page='.($number + 1);
                }

                return $page[0];
            },
            $url
        );

        return $app->json(
            $articles,
            200,
            [
                'X-Max-Pages' => $maxPages,
                'Link' => ['<'.$first.'>; rel=first', "<$prev>; rel=prev", "<$next>; rel=next"],
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
        $article = $app['article.service']->getArticleWithSlug($slug);
        $blog = $app['blog.service']->getBlogWithSlug($article['blog_slug']);

        return $app['twig']->render(
            'plugins/contents/items/view.twig',
            [
                'article' => FullArticleView::fromArray($article),
                'blog' => $blog,
                'preview' => false,
            ]
        );
    }
}
