<?php


App::import('Lib', 'Access.AccessResource');

/**
* 
*/
class TokenResource implements AccessResource
{
	private $token;
	
	function __construct($token)
	{
		$this->token = $token;
	}
	
	public function value()
	{
		return $this->token;
	}
	
	public function pattern()
	{
		return $this->token;
	}
}


?>