<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/5/17
 * Time: 12:52
 */

namespace Mh13\plugins\cantine\infrastructure\web;


use League\Tactician\CommandBus;
use Mh13\plugins\cantine\application\CantineReadModel;
use Mh13\plugins\cantine\application\GetMenuForDay;
use Mh13\plugins\cantine\application\GetMenuForWeek;


class CantineController
{
    /**
     * @var CantineReadModel
     */
    private $readModel;
    private $templating;
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CantineReadModel $readModel, CommandBus $bus, $templating)
    {
        $this->readModel = $readModel;
        $this->templating = $templating;
        $this->bus = $bus;
    }

    public function today()
    {

        $today = new \DateTimeImmutable();
        $getMenuForDay = new GetMenuForDay($today);
        $result = $this->bus->handle($getMenuForDay);

        return $this->templating->render(
            'plugins/cantine/today.twig',
            [
                'meals' => $result,
            ]
        );
    }

    public function week()
    {
        $today = new \DateTimeImmutable();
        $getMenuForWeek = new GetMenuForWeek($today->format('W'), $today->format('Y'));
        $start = new \DateTimeImmutable($today->format('Y').'W'.$today->format('W'));

        $meals = $this->bus->handle($getMenuForWeek);

        return $this->templating->render(
            'plugins/cantine/week.twig',
            [
                'meals' => $meals,
                'range' => ['start' => $start, 'end' => $start->modify('+4 day')],
            ]
        );
    }

    public function month()
    {
        $today = new \DateTimeImmutable();
        $result = $this->readModel->getMealsForMonth($today);

        return $this->templating->render(
            'plugins/cantine/month.twig',
            [
                'month' => $today->format('m'),
                'meals' => $result,
                'range' => [
                    'start' => $today->modify('first day of this month'),
                    'end'   => $today->modify('last day of this month'),
                ],
            ]

        );
    }
}
