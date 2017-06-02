<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:38
 */

namespace Mh13\plugins\circulars\infrastructure\api;


use Mh13\plugins\circulars\application\service\CircularService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class CircularController
{
    /**
     * @var CircularService
     */
    private $circularService;
    private $templating;

    public function __construct(CircularService $circularService, $templating)
    {
        $this->circularService = $circularService;
        $this->templating = $templating;
    }

    public function last()
    {
        $circulars = $this->circularService->getLastCirculars();
        if (!$circulars) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse($circulars, Response::HTTP_OK);
    }
}
