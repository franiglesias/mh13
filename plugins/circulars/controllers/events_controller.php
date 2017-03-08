<?php

class EventsController extends CircularsAppController
{
    public $name = 'Events';
    public $layout = 'backend';
    public $components = array('Filters.SimpleFilters');
    public $helpers = array('Circulars.Events', 'Circulars.Event');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('next', 'today', 'view');
    }

    public function index()
    {
        $this->paginate['Event'][0] = 'index';
        $this->paginate['Event']['order'] = array(
            'Event.startDate' => 'asc',
        );

        $this->set('events', $this->paginate());
    }

    public function view($id = null)
    {
        try {
            $this->layout = 'basic';
            $event = $this->Event->read(null, $id);
            if (!empty($event['Event']['circular_id'])) {
                $circular = $this->Event->Circular->read(null, $event['Event']['circular_id']);
                $event['Circular'] = $circular['Circular'];
            }
            $this->set('event', $event);
        } catch (Exception $e) {
            $this->message('invalid');
            $this->xredirect($this->referer());
        }
    }

    public function add()
    {
        $this->setAction('edit');
    }

    public function edit($id = null)
    {
        if (!empty($this->data)) {
            if (!$id) {
                $this->Event->create(); // 2nd pass
            }
            // Try to save data, if it fails, retry
            if ($this->Event->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved.', true), __d('circulars', 'Event', true)), 'flash_success');
                $this->xredirect();
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __d('circulars', 'Event', true)), 'flash_validation');
            }
        }
        if (empty($this->data)) { // 1st pass
            if ($id) {
                $fields = null;
                if (!($this->data = $this->Event->read($fields, $id))) {
                    $this->message('invalid');
                    $this->xredirect();
                }
            }
            $this->saveReferer(); // Store actual referer to use in 2nd pass
        }
    }

    public function next($limit = null)
    {
        $this->paginate['Event'][0] = 'next';
        if (!empty($limit)) {
            $this->paginate['Event']['limit'] = $limit;
        }
        $events = $this->paginate();

        $template = $this->isRequestedViaAjax() ?
            'plugins/circulars/ajax/nextevents.twig' :
            'plugins/circulars/nextevents.twig';

        $this->autoRender = false;
        return $this->render(
            $template,
            ['events' => $events]
        );
    }

    public function today()
    {
        $this->layout = 'basic';
        $this->paginate['Event'][0] = 'today';
        $events = $this->paginate();
        $this->set(compact('events'));
        if (!empty($this->params['requested'])) {
            return $events;
        }
    }
}
