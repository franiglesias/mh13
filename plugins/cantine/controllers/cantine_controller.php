<?php


class CantineController extends CantineAppController
{
    public $name = 'Cantine';

    public $uses = array(
        'Cantine.CantineMenuDate',
        'School.Student',
    );

    public $helpers = array(
        'Cantine.Cantine',
    );

    public $layout = 'cantine';

    public $components = array('Filters.SimpleFilters');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->Auth->deny('index', 'attendances');
    }

    public function home()
    {
        return $this->render('plugins/cantine/home.twig');
    }
    /**
     * Returns the cantine menu for today.
     */
    public function today($short = false)
    {
        $result = $this->CantineMenuDate->find('today');

        $template = $this->isRequestedViaAjax() && $short ?
            'plugins/cantine/ajax/today.twig' :
            'plugins/cantine/today.twig';

        $this->autoRender = false;
        return $this->render(
            $template, [
                'meals' => $result[0]['CantineWeekMenu']['CantineDayMenu'][date('w') - 1],
                'nutrition' => $result[0]['CantineWeekMenu'],
            ]
        );
    }

    public function week($week = false)
    {
        $range = array(
            'start' => strtotime('last monday'),
            'end' => strtotime('Friday this week'),
        );
        $result = $this->CantineMenuDate->find('range', $range);
        $this->set(compact('range', 'result'));

        return $this->render(
            'plugins/cantine/week.twig',
            [
                'range' => $range,
                'month' => $result,
            ]
        );

    }

    public function month($month = false)
    {
        $range = array(
            'start' => strtotime(date('Y-m-01')),
            'end' => strtotime(date('Y-m-t')),
        );
        $result = $this->CantineMenuDate->find('range', $range);

        $this->set(compact('range', 'result'));

        return $this->render(
            'plugins/cantine/month.twig',
            [
                'range' => $range,
                'month' => $result,
            ]
        );
    }

    public function attendances($date = null)
    {
        $this->layout = 'backend';
        $date = $this->SimpleFilters->getFilter('Attendance.date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        // $this->set(compact('attendances', 'stats', 'date', 'incidences'));
        $this->set(array(
            'date' => $date,
            'incidences' => $this->Student->CantineIncidence->find('all', array(
                    'conditions' => array('date' => $date),
                    'contain' => array('Student'),
                    )
                ),
            'stats' => $this->Student->find('cantineStats2', array('date' => $date)),
            'attendances' => $this->Student->find('cantine', array('date' => $date)),
        ));
    }
}
