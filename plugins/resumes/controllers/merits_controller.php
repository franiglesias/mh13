<?php
class MeritsController extends ResumesAppController {

	var $name = 'Merits';
	var $layout = 'resumes';

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	public function show($type = null)
	{
        $this->redirectIfThereIsNoValidUserConnected();
		$this->paginate['Merit'][0] = 'show';
		$this->paginate['Merit']['merit_type_id'] = $type;
        $this->paginate['Merit']['resume_id'] = $this->Session->read('Resume.Auth.id');
		$merits = $this->paginate('Merit');
		$meritType = $this->Merit->MeritType->find('first', array('conditions' => array('id' => $type)));

        return $this->render(
            'plugins/resumes/merits/show.twig',
            [
                'merits' => $merits,
                'meritType' => $meritType,
                'type' => $type,
            ]
        );
	}

    protected function redirectIfThereIsNoValidUserConnected()
    {
        if (!$this->Session->read('Resume.Auth.id')) {
            $this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
        }
    }

    function edit($id = null, $type = null)
    {
        $this->redirectIfThereIsNoValidUserConnected();
		if (!empty($this->data)) {
			if ($this->Merit->save($this->data)) {
                $this->Session->setFlash(
                    sprintf(__('The %s has been saved.', true), __d('resumes', 'Merit', true)),
                    'success'
                );
				$this->xredirect();
			} else {
                $this->Session->setFlash(
                    sprintf(__('The %s could not be saved. Please, try again.', true), __d('resumes', 'Merit', true)),
                    'warning'
                );
			}
		}
		if (empty($this->data)) {
			if ($id) {
				if (!($this->data = $this->Merit->read(null, $id))) {
                    $this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('resumes', 'Merit', true)), 'alert');
					$this->xredirect();
				}
			} else {
                $this->instatiateNewMerit($type);
                $this->data = $this->Merit->data;
            }
			$this->saveReferer();
		}

        $meritType = $this->Merit->MeritType->find('first', array('conditions' => array('id' => $type)));

        return $this->render(
            'plugins/resumes/merits/edit.twig',
            [
                'meritType' => $meritType,
                'data' => $this->data,
            ]
        );
    }

    /**
     * @param $type
     */
    protected function instatiateNewMerit($type)
    {
        $this->Merit->create();
        $this->Merit->set(
            [
                'merit_type_id' => $type,
                'resume_id' => $this->Session->read('Resume.Auth.id'),
                'id' => String::uuid(),
            ]
        );
    }

}
?>