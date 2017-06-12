<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 7/4/17
 * Time: 12:46
 */

namespace Mh13\plugins\contents\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\article\GetArticleByAlias;
use Mh13\plugins\contents\application\article\GetArticlesByRequest;
use Mh13\plugins\contents\application\article\request\ArticleRequestBuilder;
use Mh13\plugins\contents\application\blog\GetBlogByAlias;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\model\ArticleListView;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\model\FullArticleView;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class ArticleController
{
    /**
     * @var CommandBus
     */
    private $bus;
    private $templating;

    public function __construct(CommandBus $bus, $templating)
    {

        $this->bus = $bus;
        $this->templating = $templating;
    }

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
        $articleRequest = ArticleRequestBuilder::fromQuery($request->query, $this->bus)->getRequest();
        $articles = $this->bus->handle(new GetArticlesByRequest($articleRequest));


        return $this->templating->render(
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

    /**
     * Shows a view for the article specified by a sl
     *
     * @param string      $slug
     * @param Application $app
     *
     * @return string
     */
    public function view($slug)
    {
        $article = $this->bus->handle(new GetArticleByAlias($slug));
        $blog = $this->bus->handle(new GetBlogByAlias($article['blog_slug']));

        return $this->templating->render(
            'plugins/contents/items/view.twig',
            [
                'article' => FullArticleView::fromArray($article),
                'blog' => $blog,
                'preview' => false,
            ]
        );
    }
}
