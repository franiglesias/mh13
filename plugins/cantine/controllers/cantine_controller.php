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
    }
    /**
     * Returns the cantine menu for today.
     */
    public function today()
    {
        $result = $this->CantineMenuDate->find('today');

        $template = $this->isRequestedViaAjax() ?
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
        if ($week) {
            $range = array(
                'start' => strtotime('last monday'),
                'end' => strtotime('Friday this week'),
            );
        } else {
            $range = array(
                'start' => strtotime(date('Y-m-d')),
                'end' => strtotime('+ 1 week'),
            );
        }
        $result = $this->CantineMenuDate->find('range', $range);
        $this->set(compact('range', 'result'));
    }

    public function month($month = false)
    {
        if ($month) {
            $range = array(
                'start' => strtotime(date('Y-m-01')),
                'end' => strtotime(date('Y-m-t')),
            );
        } else {
            $range = array(
                'start' => strtotime(date('Y-m-d')),
                'end' => strtotime('+ 1 month'),
            );
        }
        $result = $this->CantineMenuDate->find('range', $range);

        $this->set(compact('range', 'result'));
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
