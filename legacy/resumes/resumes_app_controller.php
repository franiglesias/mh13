<?php

class ResumesAppController extends AppController
{
    /**
     * Prepares some global variables to be available to every resumes template
     */
    public function beforeRender()
    {
        parent::beforeRender();
        $this->twig->addGlobal('visitor', $this->Session->read('Resume.Auth'));
        $this->twig->addGlobal('types', $this->getListOfAvailableTypes());

        $this->twig->addGlobal('positions', $this->getListOfAvailablePositions());
    }

    protected function getListOfAvailableTypes()
    {
        App::import('Model', 'Resumes.MeritType');
        $MT = ClassRegistry::init('MeritType');

        return $MT->find('all');
    }

    protected function getListOfAvailablePositions()
    {
        App::import('Model', 'Resumes.Position');
        $Position = ClassRegistry::init('Position');

        return $Position->find('list');
    }

}

