<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 12:10
 */

namespace Mh13\plugins\contents\infrastructure\web;


use League\Tactician\CommandBus;
use Silex\Application;


class BlogController
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


    public function view($slug, Application $app)
    {
        $blog = $app['blog.service']->getBlogWithSlug($slug);

        return $this->templating->render(
            'plugins/contents/channels/view.twig',
            [
                'blog'     => $blog,
                'tag'      => false,
                'level_id' => false,
            ]
        );
    }

    public function public (Application $app)
    {
        $blogs = $app['blog.service']->getPublicBlogs();

        return $app->json($blogs);
    }

}
