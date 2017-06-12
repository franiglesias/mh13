<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 12:10
 */

namespace Mh13\plugins\contents\infrastructure\api;


use League\Tactician\CommandBus;
use Mh13\plugins\contents\application\blog\GetPublicBlogs;
use Symfony\Component\HttpFoundation\JsonResponse;


class BlogController
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {

        $this->bus = $bus;
    }

    public function public ()
    {
        $blogs = $this->bus->handle(new GetPublicBlogs());

        return new JsonResponse($blogs);
    }

}
