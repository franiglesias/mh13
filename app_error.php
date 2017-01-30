<?php

App::import('HttpSocket');

class AppError extends ErrorHandler
{
	public function notAllowed($params)
	{
		$url = '';
		$redirect = '/';
		extract($params, EXTR_OVERWRITE);
		$url = Router::normalize($url);
		$this->controller->Theme->load($this->controller->theme);
		$this->controller->layout = 'error';
		$this->controller->header("HTTP/1.0 401 Not Allowed");
		$this->controller->set(array(
			'url' => h($url),
			'redirect' => $redirect,
			'code' => '401',
			'name' => __('Not Allowed', true),
			'message' => h($url),
			'base' => $this->controller->base
		));
		$this->_outputMessage('not_allowed');
	}
	
	function error404($params) {
		$url = $this->controller->here;
		$this->controller->Theme->load($this->controller->theme);
		$redirect = '/';
		extract($params, EXTR_OVERWRITE);
		$url = Router::normalize($url);
		$this->controller->layout = 'error';
		$this->controller->header("HTTP/1.0 404 Not Found");
		$this->controller->set(array(
			'url' => h($url),
			'redirect' => $redirect,
			'code' => '404',
			'name' => __('Not Found', true),
			'message' => h($url),
			'base' => $this->controller->base
		));
		$this->_outputMessage('error404');
	}
	
	public function exception($params)
	{
		$url = $this->controller->here;
		$redirect = '/';
		extract($params, EXTR_OVERWRITE);
		$url = Router::normalize($url);
		$this->controller->Theme->load($this->controller->theme);
		$this->controller->set(array(
			'url' => h($url),
			'redirect' => $redirect,
			'code' => '---',
			'name' => __('Exception', true),
			'message' => $exception,
			'base' => $this->controller->base,
			'exception' => $exception
		));

		$this->_outputMessage('exception');
	}
	public function missingController($params) {
		return $this->error404($params);
	}
	
}


?>