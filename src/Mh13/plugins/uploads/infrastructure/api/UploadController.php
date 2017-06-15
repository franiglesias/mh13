<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 15/6/17
 * Time: 14:01
 */

namespace Mh13\plugins\uploads\infrastructure\api;


use League\Tactician\CommandBus;
use Mh13\plugins\uploads\application\GetDownloadsForObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UploadController
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {

        $this->bus = $bus;
    }


    public function downloads(Request $request)
    {
        $query = $request->query;
        $context = $query->get('context');
        $alias = $query->get('alias');
        $files = $this->bus->handle(new GetDownloadsForObject($context, $alias));

        return new JsonResponse($files);
    }
}
