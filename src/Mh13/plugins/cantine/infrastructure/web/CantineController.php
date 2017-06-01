<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/5/17
 * Time: 12:52
 */

namespace Mh13\plugins\cantine\infrastructure\web;


use Mh13\plugins\cantine\application\CantineReadModel;


class CantineController
{
    /**
     * @var CantineReadModel
     */
    private $readModel;
    private $templating;

    public function __construct(CantineReadModel $readModel, $templating)
    {
        $this->readModel = $readModel;
        $this->templating = $templating;
    }

    public function today()
    {
        $today = new \DateTimeImmutable();
        $result = $this->readModel->getTodayMeals($today);

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
        $result = $this->readModel->getWeekMeals($today);

        return $this->templating->render(
            'plugins/cantine/week.twig',
            [
                'meals' => $result,
                'range' => ['start' => $today, 'end' => $today],
            ]
        );
    }

    public function month()
    {
        $today = new \DateTimeImmutable();
        $result = $this->readModel->getMonthMeals($today);

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