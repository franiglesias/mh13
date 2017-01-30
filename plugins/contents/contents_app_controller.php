<?php

class ContentsAppController extends AppController {
	var $layout = 'backend';

/**
 * A handful of common methods for Contents Plugin Controllers
 */

/**
 * Autosave method
 *
 * Receives an ajax request and tries to save data in form. If there are invalid fields, returns them to the autosave.js script.
 * You need to create an json/edit.ctp view
 *
 * @param string $id 
 * @return json ajax response with message and errors if any
 */
	public function autosave($id = null) {
		if (!empty($this->data)) {
			if ($this->{$this->modelClass}->save($this->data)) {
				$identifier = $this->data[$this->modelClass][$this->{$this->modelClass}->displayField];
				$ajaxResponse = array(
					'message' => sprintf(__d('contents', '%s: <strong>%s</strong> was automatically saved.', true), $this->modelClass, $identifier),
					'errors' => false
					);
			} else {
				$ajaxResponse = array(
					'message' => __d('contents', 'Some problemas found. Please. Check the following fields.', true),
					'errors' => $this->{$this->modelClass}->invalidFields(),
					'model' => $this->modelClass
					);
			}
		}
		$this->set(compact('ajaxResponse'));
		Configure::write('debug', 0);
		$this->RequestHandler->respondAs('js');
		$this->render('json/edit', 'ajax');
	}


/**
 * Sets the URL for magic autosave. You should include a call to $this->_useAutoSave() into the edit method so Ajax action could learn form where to retrieve data
 *
 * @return void
 */
	protected function _useAutosave()
	{
		$this->setJsVar('jsonAction', Router::url(array(
			'action' => 'autosave')
			));
	}
	
/**
 * Manages changes in required credentials for HTTP Authentication. If logged user or password are different from required,
 * unsets the stored $_SERVER keys to force a logout
 *
 * @param string $user User required for the resource
 * @param string $pwd Password required for the resource
 * @return void
 */
	protected function resetHttpAuth($credentials)
	{
		if (!empty($_SERVER['PHP_AUTH_USER']) && ($credentials['guest'] != $_SERVER['PHP_AUTH_USER'] || $credentials['guestpwd'] != $_SERVER['PHP_AUTH_PW'])) {
			unset($_SERVER['PHP_AUTH_USER']);
			unset($_SERVER['PHP_AUTH_PW']);
		}
	}

/**
 * Generic callback to trigger a not allowed error
 *
 * @return void
 */
	public function notAllowed()
	{
		$this->cakeError('notAllowed', array('url' => $this->here, 'redirect' => $this->referer()));
	}


}

?>