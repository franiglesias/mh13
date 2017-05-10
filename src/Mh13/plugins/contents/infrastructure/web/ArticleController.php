<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use Mh13\plugins\contents\application\service\article\ArticleRequestBuilder;
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

        if (!$articles) {
            return $app->json(['code' => 204, 'message' => 'No articles found for this query.'], 204);
        }

        $currentPage = $articleRequest->getPage();

        $maxPages = $articleRequest->maxPages($app['article.service']->getArticlesCountForRequest($articleRequest));


        return $app->json(
            $articles,
            200,
            [
                'X-Max-Pages' => $maxPages,
                'X-Current-Page' => $currentPage,
                'Link' => $this->computeLinks($request, $currentPage, $maxPages),
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => ['GET', 'PUT'],
            ]
        );
    }

    /**
     * @param Request $request
     * @param         $currentPage
     * @param         $maxPages
     *
     * @return array
     */
    protected function computeLinks(Request $request, $currentPage, $maxPages): array
    {
        $url = $this->cleanUrlAndInjectPageIfNeeded($request);

        $prevPage = $currentPage > 1 ? $currentPage - 1 : 1;
        $nextPage = $currentPage < $maxPages ? $currentPage + 1 : $maxPages;

        $first = preg_replace('/page\=\d+/', 'page=1', $url);
        $prev = preg_replace('/page\=\d+/', 'page='.$prevPage, $url);
        $next = preg_replace('/page\=\d+/', 'page='.$nextPage, $url);

        return ["<$first>; rel=first", "<$prev>; rel=prev", "<$next>; rel=next"];
    }

    /**
     * @param Request $request
     *
     * @return mixed|string
     */
    protected function cleanUrlAndInjectPageIfNeeded(Request $request)
    {
        $url = str_replace(['&url=articles', '%2F'], '', $request->getUri());

        if (strpos($url, 'page=') === false) {
            $url = $url.'&page=1';
        }

        return $url;
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
