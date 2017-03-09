<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 *
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

 /**
  * This is a placeholder class.
  * Create the same file in app/app_controller.php.
  *
  * Add your application-wide methods in the class below, your controllers
  * will inherit them.
  *
  * @link http://book.cakephp.org/view/957/The-App-Controller
  */
 require_once '../vendor/autoload.php';

class AppController extends Controller
{
    public $components = array(
        'Security',
        'Session',
        'Ui.Theme',
        'DebugKit.Toolbar',
        'Auth' => array(
            'userModel' => 'Access.User',
            'logoutRedirect' => '/',
            'loginRedirect' => array(
                'plugin' => 'access',
                'controller' => 'users',
                'action' => 'dashboard',
                ),
            'userScope' => array('User.active >' => 0),
            'authorize' => 'controller',
            'autoRedirect' => false,
            'flashElement' => 'flash_auth',
            'loginAction' => array(
                'admin' => false,
                'plugin' => 'access',
                'controller' => 'users',
                'action' => 'login',
                ),
            'loginError' => 'Bad credentials',
            'authError' => 'Need to be authenticated',
            ),
        'Access.Access',
        'RequestHandler',
        'AjaxRequest',
        );

    public $helpers = array(
        'Html',
        'Js' => array('Jquery'),
        'Session',
        'Time',
        'Rss',
        'Paginator',
        'Ui.Table',
        'Ui.Media',
        'Ui.Widget',
        // 'Ui.Module',
        'Ui.Article',
        'Ui.Backend',
        'Ui.XHtml',
        'Ui.FHtml',
        'Ui.FForm',
        'Ui.Block',
        'Ui.Page',
        'Uploads.Upload',
        'Menus.Bar',
        'Menus.Wbar',
        'Menus.Menu',
        'Contents.Items',
        'Contents.Item',
        'Contents.Channel',
        'Circulars.Circulars',
        'Circulars.Circular',
        'Circulars.Events',
        'Circulars.Event',

        // 'Gdata.Analytics',
        );

    /**
     * Used to pass data to the Javascript layer.
     *
     * @var array
     */
    public $_jsVars = array();
    /**
     * Flag.
     *
     * @var bool
     */
    public $changed;
    /**
     * Theme name to apply to views.
     *
     * @var string
     */
    public $theme = false;
    /**
     * Array of key => label actions for Selections at index pages.
     *
     * Automatically passed to the view beforeRender
     *
     * @var string
     */
    public $selectionActions = array();
    public $returnTo;
    public $tmp;

    public $twig;

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->loginError = __('Authentication failed. Bad credentials.', true);
        $this->Auth->authError = __('You need to login to access this url.', true);
        $this->Auth->allow(array('display', 'selection', 'executeSelection'));
        $this->Security->validatePost = false;
        $this->Security->blackHoleCallback = '_confirmAction';
        // Adjustments by ajax request
        if (!$this->RequestHandler->isAjax()) {
            $this->Security->requirePost('delete');
        }
        if ($this->RequestHandler->isAjax()) {
            Configure::write('Session.checkAgent', false);
            Configure::write('debug', 0);
        }
        $this->setJsVar('assets', Router::url('/').'ui'.DS.IMAGES_URL.'assets'.DS);

        $loader = new Twig_Loader_Filesystem('../views');
        $this->twig = new Twig_Environment($loader, [
            'debug' => true,
        ]);
        $this->twig->addExtension(new Twig_Extension_Debug());
        require_once 'libs/twig/Twig_Extension_Media.php';
        $this->twig->addExtension(new Twig_Extension_Media());
        $this->twig->addGlobal('Site', Configure::read('Site'));
        $this->twig->addGlobal('Organization', Configure::read('Organization'));
        $this->twig->addGlobal('Home', Configure::read('Home'));
        $this->twig->addGlobal('Analytics', Configure::read('Analytics'));
        $this->twig->addGlobal('SchoolYear', Configure::read('SchoolYear'));
        $this->twig->addGlobal('GApps', Configure::read('GApps'));

        $this->twig->addGlobal('jsVars', $this->_jsVars);
        $this->twig->addGlobal('BaseUrl', Router::url('/', true));
        $this->twig->addGlobal('Auth', $this->Session->read('Auth'));
        $this->twig->addGlobal('Params', $this->params);
    }

    /**
     * http://www.sanisoft.com/blog/2010/09/20/cakephp-passing-data-from-controller-to-javascript-files/.
     */
    public function setJsVar($name, $value)
    {
        $this->_jsVars[$name] = $value;
    }

    /**
     * Wraps AccessComponent->isAuthorized.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->Access->isAuthorizedToken($this->params);
    }

    /**
     * Saves referer when needed for 2-pass controller action.
     *
     * @author Fran Iglesias
     */
    public function saveReferer()
    {
        if ($this->RequestHandler->isAjax()) {
            return;
        }
        if (!empty($this->data['_App']['referer'])) {
            return;
        }
        $this->data['_App']['referer'] = $this->referer();
    }

    /**
     * Saves and Restore App Data for redirecting after a model reload in a form.
     *
     * @author Fran Iglesias
     */
    public function preserveAppData()
    {
        if (empty($this->data['_App'])) {
            return;
        }
        $this->tmp = $this->data['_App'];
    }

    public function restoreAppData()
    {
        if (empty($this->tmp)) {
            return;
        }
        $this->data['_App'] = $this->tmp;
        $this->tmp = null;
    }

    // Redirection management

    /**
     * Manage actions catch by Security Component.
     */
    public function _confirmAction($reason = null)
    {
        if ($reason === 'post') {
            switch ($this->action) {
                case 'delete':
                    $this->redirect(array(
                        'action' => 'confirmation',
                        $this->params['pass'][0],
                        'forward' => $this->action,
                        'reason' => $reason,
                    ));
                    break;
                default:
                    break;
            }
        }
        $code = 404;
        if ($reason == 'login') {
            $code = 401;
        } else {
            throw new Exception('Problem accessing '.$this->name.'::'.$this->action.' reason: '.$reason);
            $this->Session->setFlash(__('Access denied', true), 'flash_alert');
        }
        $this->redirect(null, $code, true);
    }

    /**
     * Generic confirm action.
     *
     * @param mixed $id $id for the record
     */
    public function confirmation($id = null)
    {
        $this->layout = 'backend';
        $this->set(
            array(
                'modelClass' => $this->modelClass,
                'displayField' => $this->{$this->modelClass}->displayField,
                'url' => array('action' => $this->params['named']['forward'], $id),
                'reason' => $this->params['named']['reason'],
                'action' => $this->params['named']['forward'],
                'record' => $this->{$this->modelClass}->read(null, $id),
                'referer' => $this->referer(),
            )
        );
        $this->render('/elements/confirm/confirmation');
    }

    /**
     * Generic Method to render template
     *
     * @param string $template
     * @param array $vars
     */
    function render($template, $vars = [])
    {
        $this->beforeRender();
        $this->Component->triggerCallback('beforeRender', $this);
        $this->autoRender = false;
        $vars = array_merge($vars, ['Paging' => $this->paginate]);
        return $this->twig->render($template, $vars);
    }

    public function beforeRender()
    {
        // Error Layout
        $this->_setErrorLayout();
        // Pass needed vars to JS
        $this->set('jsVars', $this->_jsVars);
        $this->set('Site', Configure::read('Site'));

        // Force browser to reload the page instead of showing the cached view
        if (in_array($this->action, array('delete', 'logout', 'index'))) {
            $this->disableCache();
        }

        if (!empty($this->selectionActions) && ($this->action == 'index' || $this->action == 'selection')) {
            $this->set('selectionActions', $this->selectionActions);
        }

        // Globally manages print named param setting layout to print
        if (!empty($this->params['named']['print'])) {
            $this->layout = 'print';
        }
    }

    public function _setErrorLayout()
    {
        if ($this->name == 'CakeError' && !defined('CAKE_TEST_EXECUTION')) {
            $this->layout = 'error';
            $this->log(sprintf('[%s] %s: %s', $this->viewVars['code'], $this->viewVars['name'], $this->viewVars['message']), 'mh-error');
        }
    }

    // End redirect Management

    /**
     * Generic/default delete action for any controller.
     *
     * Set following fields as hidden
     *
     * 'identity': contains a string that identifies the record about to be deleted
     *
     * @param string $id
     */
    public function delete($id)
    {
        if ($this->{$this->modelClass}->delete($id, true)) {
            $this->message('delete');
            $this->xredirect();
        }
        $this->message('invalid');
        $this->xredirect();
    }

    /**
     * Manage Secure deletion of models. Forces a POST request and shows a confirmation dialog.
     *
     * http://articles.classoutfit.com/cakephp-adding-a-delete-confirm-function/
     * https://archive.ad7six.com/2007/08/23/Generic-capability-based-security-(CSRF-prevention).html
     */

    public function message($type = false)
    {
        $model = $this->modelClass;
        $field = $this->$model->displayField;
        $identity = __('n/a', true);
        if (!empty($this->data[$model][$field])) {
            $identity = $this->data[$model][$field];
            if (is_array($identity)) {
                $identity = implode('/', $identity);
            }
        }
        switch ($type) {
            case 'success':
                $message = sprintf(__('Data for %s: <strong>%s</strong> was saved.', true), $model, $identity);
                $template = 'flash_success';
                break;
            case 'validation':
                $message = sprintf(__('Failed to save %s: <strong>%s</strong>. Please, check fields.', true), $model, $identity);
                $template = 'flash_validation';
                break;
            case 'invalid':
                $message = sprintf(__('Can\'t find the %s.', true), $model);
                $template = 'flash_alert';
                break;
            case 'delete':
                $message = sprintf(__('%s was deleted.', true), $model);
                $template = 'flash_success';
                break;
            case 'error':
                $message = sprintf(__('Something went wrong with %s.', true), $model);
                $template = 'flash_alert';
                break;
            default:
                $message = sprintf(__('Action was performed with %s: <strong>%s</strong>', true), $model, $identity);
                $template = 'flash_info';
            break;
        }
        $this->Session->setFlash($message, $template);
        $this->log($message, 'mh-messages');

        return $message;
    }

    /**
     * Redirects, managing Save and Work condition and stored referers.
     *
     * @param string $parent_id
     * @param string $action
     *
     * @author Fran Iglesias
     */
    public function xredirect($parent_id = null, $action = 'index')
    {
        if (!empty($this->params['form']['save_and_work'])) {
            return false;
        }
        if ($this->RequestHandler->isAjax()) {
            $url = array('action' => $action, $parent_id);
            $this->redirect($url);

            return true;
        }

        if (!empty($this->data['_App']['referer'])) {
            $referer = $this->data['_App']['referer'];
            $this->resetReferer();
            $this->redirect($referer);

            return true;
        }
        $url = $this->referer();
        if (method_exists($this, 'index')) {
            $url = array('action' => 'index');
        }
        $this->redirect($url);
    }

    /**
     * Resets stored referer.
     *
     * @author Fran Iglesias
     */
    public function resetReferer()
    {
        unset($this->data['_App']['referer']);
    }

    /**
     * Receives Selection data and prepares for a confirm action. Assumes find('list') can provide
     * a significative identity for the model. Set displayField as needed in the model. Heavily relies
     * in cakephp naming conventions.
     */
    public function selection()
    {
        $ids = array();
        // debug($this->data);
        foreach ($this->data[$this->modelClass]['id'] as $id => $selected) {
            if ($selected) {
                $ids[] = $id;
            }
        }
        if (empty($ids)) {
            $this->Session->setFlash(__d('errors', 'Nothing selected.', true), 'flash_error');
            $this->redirect($this->referer());
        }
        $referer = $this->referer();
        $action = $this->data['_Selection']['action'];
        $records = $this->{$this->modelClass}->find('list', array('conditions' => array($this->modelClass . '.id' => $ids)));
        $this->set(compact('referer', 'action', 'records'));
        $this->set('modelClass', $this->modelClass);
        $this->render('/elements/confirm/selection');
    }

    /**
     * Generic action to postprocess selections.
     */
    public function executeSelection()
    {
        if (empty($this->data)) {
            $this->redirect($this->referer());
        }
        $this->autoRender = false;
        $action = '_' . $this->data['_Selection']['action'];
        if (!method_exists($this, $action)) {
            $this->Session->setFlash(__d('errors', 'No action performed on selection.', true), 'flash_error');
            $this->log(sprintf('Action %s doesn\'t exists on model %s', $action, $this->alias), 'mh-error');
            $this->redirect($this->data['_Selection']['referer']);
        }
        $ids = Set::extract($this->data, '/' . $this->modelClass . '/id');
        $this->$action($ids);
        $this->redirect($this->data['_Selection']['referer']);
    }

    protected function isRequestedViaAjax()
    {
        return (!empty($this->params['requested'])) || $this->RequestHandler->isAjax();
    }
}
