<?php

namespace Framework;

Class HTTPRequest extends AppComponent
{
	
	public function getExist($var)
	{
		return isset($_GET[$var]);
	}

	public function getData($var)
	{
		return isset($_GET[$var]) ? $_GET[$var] : null;
	}

	public function postExist($var)
	{
		return isset($_POST[$var]);
	}

	public function postData($var)
	{
		return isset($_POST[$var]) ? $_POST[$var] : null; 
	}

	public function cookieExist($cookie)
	{
		return isset($_COOKIE[$var]) ? $_COOKIE[$var] : null;
	}

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getURL()
	{
		return $_SERVER['REQUEST_URI'];
	}

} 