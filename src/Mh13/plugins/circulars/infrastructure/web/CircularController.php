<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 2/6/17
 * Time: 9:38
 */

namespace Mh13\plugins\circulars\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\circulars\application\circular\GetCircular;
use Mh13\plugins\circulars\application\circular\GetLastCirculars;


class CircularController
{
    private $templating;
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus, $templating)
    {
        $this->templating = $templating;
        $this->bus = $bus;
    }

    public function last()
    {
        $command = new GetLastCirculars(5);
        $circulars = $this->bus->handle($command);

        return $this->templating->render(
            'plugins/circulars/current.twig',
            [
                'circulars' => $circulars,
            ]
        );
    }

    public function view($id)
    {
        $command = new GetCircular($id);
        $circular = $this->bus->handle($command);

        return $this->templating->render(
            'plugins/circulars/view.twig',
            [
                'circular' => $circular,
            ]
        );
    }
}
