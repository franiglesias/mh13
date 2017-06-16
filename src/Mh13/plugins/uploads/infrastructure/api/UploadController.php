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
use Symfony\Component\HttpFoundation\Response;


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
        try {
            $query = $request->query;
            $context = $query->get('context');
            $alias = $query->get('alias');
            if (!$context || !$alias) {
                return new JsonResponse([], Response::HTTP_BAD_REQUEST);
            }
            $files = $this->bus->handle(new GetDownloadsForObject($context, $alias));
            if (!$files) {
                return new JsonResponse([], Response::HTTP_NO_CONTENT);
            }

            return new JsonResponse($files, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['code' => 500, 'message' => $exception->getMessage().' '.get_class($exception)],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
