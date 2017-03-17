<?php


class ResumesController extends ResumesAppController
{

    var $name = 'Resumes';

    var $requireLogin = ['modify', 'remove', 'preview', 'changepwd'];

    var $layout = 'resumes';

    var $helpers = array('Resumes.Resume');

    var $components = array('Notify', 'Menus.Panels', 'Filters.SimpleFilters');

    /**
     * Some common preparations before
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(
            array(
                'login',
                'confirm',
                'modify',
                'remove',
                'create',
                'home',
                'logout',
                'preview',
                'changepwd',
                'forgot',
                'recover',
            )
        );
        $this->redirectToLoginWhenNeeded();
    }

    protected function redirectToLoginWhenNeeded()
    {
        if ($this->actionDoesNotRequireLogin()) {
            return true;
        }
        if ($this->thereIsAnAuthenticatedUser()) {
            return true;
        }
        $this->Session->write('Resume.Auth.redirect', $this->action);
        $this->setAction('login');
    }

    /**
     * @return bool
     */
    protected function actionDoesNotRequireLogin()
    {
        return !in_array($this->action, $this->requireLogin);
    }

    /**
     * @return mixed
     */
    protected function thereIsAnAuthenticatedUser()
    {
        return $this->Session->read('Resume.Auth.id');
    }

    /**
     * Visitor registers and create a new resume
     *
     * @return string
     */

    public function create()
    {
        $this->saveReferer();
        if (!empty($this->data['Resume'])) {
            $this->Resume->create();
            if ($this->Resume->save($this->data)) {
                $this->message('success');
                $this->Session->write('Resume.Auth', $this->Resume->identifier());
                ClassRegistry::getObject('EventManager')->notify($this->Resume, 'resumes.resume.new');
                $this->redirect(array('action' => 'home'));
            } else {
                $this->message('validation');
            }

        }
        return $this->render('plugins/resumes/create.twig');
    }

    /**
     * Shows terms and conditions page
     * @return string
     */
    public function confirm()
    {
        return $this->render('plugins/resumes/confirm.twig');
    }

    /**
     * Manages Applicants login
     * @return string
     */
    public function login()
    {
        if (empty($this->data)) {
            return $this->render('plugins/resumes/login.twig', []);
        }
        try {
            $resume = Resume::fromLogin($this->data);
            $redirectTo = $this->Session->read('Resume.Auth.Redirect');
            $this->Session->write('Resume.Auth', $resume->data['Resume']);
            $this->redirect(
                array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => $redirectTo ? $redirectTo : 'home')
            );
        } catch (Exception $exception) {
            $this->Session->setFlash(
                __d('resumes', 'There is no resume registered with that email.', true),
                'alert'
            );
            $this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
        }

    }

    public function logout()
    {
        $this->Session->delete('Resume.Auth');
        $this->Session->setFlash(__d('resumes', 'Googbye!', true), 'success');
        $this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
    }

    public function modify()
    {
        if (!empty($this->data)) {
            $this->Resume->create();
            if ($this->Resume->save($this->data)) {
                $this->Session->setFlash(__d('resumes', 'Changes has been applied.', true), 'success');
                $this->xredirect();
            } else {
                $this->Session->setFlash(__d('resumes', 'Data could not be saved.', true), 'warning');
            }
        }
        if (empty($this->data)) {
            $id = $this->getIdFromSession();
            $fields = array('id', 'firstname', 'lastname', 'email', 'introduction', 'phone', 'mobile', 'photo');
            $this->data = $this->Resume->read(null, $id);
            $this->saveReferer();
        }
        $this->set('positions', $this->Resume->Position->find('list'));

        return $this->render(
            'plugins/resumes/modify.twig',
            [
                'data' => $this->data,
            ]
        );
    }

    /**
     * @return mixed
     */
    protected function getIdFromSession()
    {
        return $this->Session->read('Resume.Auth.id');
    }

    public function changepwd()
    {
        if (!empty($this->data)) {
            $this->Resume->create();
            if ($this->Resume->save($this->data)) {
                $this->Session->setFlash(__d('resumes', 'Changes has been applied.', true), 'success');
                $this->xredirect();
            } else {
                $this->Session->setFlash(__d('resumes', 'Data could not be saved.', true), 'warning');
            }
        }
        if (empty($this->data)) {
            $id = $this->getIdFromSession();
            $this->data['Resume']['id'] = $id;
            $this->saveReferer();
        }

        return $this->render('plugins/resumes/changepwd.twig', []);
    }


    /* Administrative methods */

    public function remove()
    {
        if (!empty($this->data)) {
            if (!empty($this->data['Resume']['delete'])) {
                $this->Resume->delete($this->data['Resume']['id'], true);
                $this->Session->delete('Resume.Auth');
                $this->Session->setFlash(
                    __d('resumes', 'Your data has been permanently removed.', true),
                    'success'
                );
            } else {
                $this->Session->setFlash(__d('resumes', 'You selected not to remove you data.', true), 'success');
            }
            $this->redirect(array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'home'));
        }
        $this->data['Resume']['id'] = $this->getIdFromSession();

        return $this->render('plugins/resumes/remove.twig', []);

    }

    public function home()
    {
        $completedProfile = 0;
        $stats = [];

        $visitor = $this->Session->read('Resume.Auth');
        if (!empty($visitor['id'])) {
            $completedProfile = $this->Resume->isComplete($visitor['id']);
            $stats = $this->Resume->stats($visitor['id']);
            $this->set(compact('visitor', 'completedProfile', 'stats'));
        } else {
            $this->set(compact('visitor'));
        }

        return $this->render(
            'plugins/resumes/home.twig',
            [
                'visitor' => $visitor,
                'completedProfile' => $completedProfile,
                'stats' => $stats,
                'connected' => $this->getIdFromSession(),
            ]
        );
    }

    public function preview()
    {
        $id = $this->getIdFromSession();
        $resume = $this->Resume->readCV($id);
        $this->set('resume', $this->Resume->readCV($id));

        return $this->render(
            'plugins/resumes/resume.twig',
            [
                'resume' => $resume,
            ]
        );
    }

    /**
     * Manages first step of password recovery. User arrive here and provide username
     * and/or email, so we can find him in the database and generate a ticker for recover.
     * If we can generate a ticket, we send the user a email with a link to the recover
     * action.
     *
     * @return void
     */
    public function forgot()
    {
        if (empty($this->data)) {
            return $this->render('plugins/resumes/forgot.twig');
        }
        try {
            $ticket = $this->Resume->forgot(
                $this->data['Resume']['recovery_email']
            );
            $this->set(compact('ticket'));
            $this->set('resume', $this->Resume->read('*'));
            $this->Notify->send(
                'resumes_forgot',
                $this->data['Resume']['recovery_email'],
                __d('access', 'Recover your lost password.', true)
            );

            return $this->render('plugins/resumes/forgot_ticket_sent.twig');
        } catch (OutOfBoundsException $e) {
            $this->Session->setFlash(__d('resumes', 'Email unknown.', true), 'alert');
            $this->redirect(array('action' => 'forgot'));
        } catch (Exception $e) {
            $this->Session->setFlash($e->getMessage(), 'alert');
            $this->redirect(array('action' => 'forgot'));
        }


    }

    /**/

    /**
     * Manages last step of password recovery. User arrive here with a ticket to recover password.
     * We send the generated password by email and notify the user the result of the
     * operation.
     *
     * @param string $ticket
     *
     * @return void
     */
    public function recover($ticket = null)
    {
        // $this->layout = 'access';
        if (!$ticket || !($password = $this->Resume->redeemTicket($ticket))) {
            $this->Session->setFlash(__('Invalid or expired ticket.', true), 'alert');
            $this->redirect(array('action' => 'home'));
        }
        $this->Resume->read('*');
        $this->set(compact('password'));
        $this->set('resume', $this->Resume->data);
        $result = $this->Notify->send(
            'resumes_recover',
            $this->Resume->data['Resume']['email'],
            __d('access', 'Your new password', true)
        );

        return $this->render('plugins/resumes/recover.twig');
    }

    public function index()
    {
        $this->layout = 'backend';
        if ($merit = $this->SimpleFilters->getFilter('Merit.title')) {
            $this->paginate['Resume'][0] = 'search';
            $this->paginate['Resume']['terms'] = $merit;
            unset($this->paginate['Resume']['conditions']['Merit.title LIKE']);
        }
        $this->set('resumes', $this->paginate());

    }

    public function view($id = null)
    {
        $this->layout = 'backend';
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s.', true), 'resume'));
            $this->redirect(array('action' => 'index'));
        }
        $resume = $this->Resume->readCV($id);
        $this->set('resume', $resume);

        return $this->render(
            'plugins/resumes/resume.twig',
            [
                'resume' => $resume,
            ]
        );

    }

    public function search()
    {
        $this->layout = 'backend';
        if (!empty($this->data['Resume'])) {
            $this->paginate['Resume'][0] = 'search';
            $this->paginate['Resume']['terms'] = $this->data['Resume']['terms'];
            $this->set('resumes', $this->paginate('Resume'));
            $this->render('index');
        }
    }

}

?>