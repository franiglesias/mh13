<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:38
 */

namespace Mh13\plugins\circulars\infrastructure\web;


use Mh13\plugins\circulars\application\service\CircularService;


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

        return $this->templating->render(
            'plugins/circulars/current.twig',
            [
                'circulars' => $circulars,
            ]
        );
    }

    public function view($id)
    {
        $circular = $this->circularService->getCircular($id);

        return $this->templating->render(
            'plugins/circulars/view.twig',
            [
                'circular' => $circular,
            ]
        );
    }
}
