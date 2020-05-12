<?php
namespace Framework;

if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}


class admin extends AppComponent
{
	public function setAuthentified(bool $auth)
	{
		$_SESSION['authAdmin']=$auth;
	}

	public function isValid()
	{
		return isset($_SESSION['authAdmin']) && $_SESSION['authAdmin']===true ? true : false;
	}
	public function disconnect()
	{
		unset($_SESSION['authAdmin']);
		unset($_COOKIE['loginAdmin']);
		unset($_COOKIE['passAdmin']);
		setcookie('loginAdmin', '', $_SERVER['REQUEST_TIME'] - 4200, null, null, false, true);
        setcookie('passAdmin', '', $_SERVER['REQUEST_TIME'] - 4200, null, null, false, true);
    	
	}
}