<?php

interface AccessResource {
	public function value();
	public function pattern();
}

class ResourceFactory
{
	public function make($token)
	{
		if (is_array($token)) {
			return $this->url($token);
		}
		
		if (is_object($token)) {
			return $this->object($token);
		}
		
		if (preg_match('/^\/\//', $token)) {
			return $this->token(strtolower($token));
		}
		return $this->url(strtolower($token));
	}
	
	
	private function url($url)
	{
		App::import('Lib', 'Access.UrlResource');
		return new UrlResource($url);
	}
	
	
	private function token($token)
	{
		App::import('Lib', 'Access.TokenResource');
		return new TokenResource($token);
	}

	private function object($object)
	{
		App::import('Lib', 'Access.ObjectResource');
		return new ObjectResource($object);
	}

}


?>