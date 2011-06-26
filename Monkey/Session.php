<?php

class Monkey_Session
{
	private static $_instance;
	
	public static function getSession()
	{
		if (!isset(self::$_instance))
		{
			self::$_instance = new Monkey_Session();
			session_start();
		}

		return self::$_instance;
	}

	private function __construct() { }

	public function setValueForKey($value, $key)
	{
		$_SESSION[$key] = $value;
	}

	public function getValueForKey($key)
	{
		if (array_key_exists($key, $_SESSION))
		{
			return $_SESSION[$key];
		}
		else
		{   
		    return null;
		}
	}

	public function destroy()
	{
		session_unset();
		session_destroy();
	}
}
