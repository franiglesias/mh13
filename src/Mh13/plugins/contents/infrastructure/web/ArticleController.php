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
use Mh13\plugins\contents\application\blog\GetBlogByAlias;
use Mh13\plugins\contents\infrastructure\persistence\dbal\article\model\FullArticleView;
use Silex\Application;


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
