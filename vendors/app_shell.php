<?php

/**
* Utility methods useful in many shells
*/
class AppShell extends Shell
{
	
/**
 * Waits for confirmation to proceed. Abort Shell with any answer different from yes
 *
 * @param string $message 
 * @return void
 */
	public function confirm($message) {
		$options = array('yes', 'no');
		$response = $this->in($message, $options, 'no');
		$response = strtolower($response);
		if ($response != 'yes') {
			$this->error('Operation aborted by user');
		}
		return true;
	}

/**
 * Get the current Language setting for the App
 *
 * @return void
 */
	public function language()
	{
		App::import('Core', 'L10n');
		$L10n = new L10n();
		return $L10n->lang;
	}


/**
 * Extracts a parameter given a name. If parameter doesn't exists then prompt the user to provide one. 
 *
 * @param string $name The name of the parameter
 * @param string $message The message to prompt the user if needed
 * @param string $default Default value for parameter, if false then use the same name as the parameter
 * @return string The value
 */
	protected function inParam($param, $message, $default = false) {
		if (isset($this->params[$param])) {
			return $this->params[$param];
		}
		if (!$default) {
			$default = $param;
		}
		return $this->in($message, null, $default);
	}

/**
 * Wrapper for in, repeat the prompt until user give a response
 *
 * @param string $message 
 * @param string $options 
 * @param string $default 
 * @return void
 */	
	public function required($message, $options = null, $default = false) {
		if (strpos('(req)', $message) === FALSE) {
			$message .= ' (req)';
		}
		$response = $this->in($message, $options, $default);
		if (!$response) {
			$this->out(' A response is required to continue.');
			$response = $this->required($message, $options, $default);
		}
		return $response;
	}

/**
 * @todo there is a bug if q and no data entered
 *
 * @param string $message 
 * @param string $default 
 * @return void
 */	
	public function multi($message, $default)
	{
		$responses = array();
		$finish = false;
		$this->out($message);
		do {
			$response = $this->in($message, null, $default);
			$this->out($response);
			if ($response != 'q') {
				$message .= ', '.$response;
				$responses[] = $response;
			} else {
				$finish = true;
			}
		} while ($finish == false);
		return $responses;
	}



	
}

?>