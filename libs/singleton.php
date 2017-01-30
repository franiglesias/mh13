<?php

/**
* 
*/
class Singleton
{
	private static $_instance = null;
	
	private function __construct()
	{
	}
	
	public static function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	public function __clone()
	{
		
	}
	
	public function __wakeup()
	{
	}
}


?>