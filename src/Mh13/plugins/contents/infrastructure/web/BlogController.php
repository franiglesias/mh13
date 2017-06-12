<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 12:10
 */

namespace Mh13\plugins\contents\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\blog\GetBlogByAlias;
use Mh13\plugins\contents\application\blog\GetPublicBlogs;
use Symfony\Component\HttpFoundation\JsonResponse;


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


    public function view($slug)
    {
        $command = new GetBlogByAlias($slug);
        $blog = $this->bus->handle($command);
        return $this->templating->render(
            'plugins/contents/channels/view.twig',
            [
                'blog'     => $blog,
                'tag'      => false,
                'level_id' => false,
            ]
        );
    }

    public function public ()
    {
        $blogs = $this->bus->handle(new GetPublicBlogs());

        return new JsonResponse($blogs);
    }

}
