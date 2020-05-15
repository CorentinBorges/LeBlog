<?php

namespace Entity;

	session_start();

use Framework\Entity;

class User extends Entity
{
	protected 	$name,
				$firstName,
				$pseudo,
				$mail,
				$password,
                $roleId,
				$valid;

	const INVALID_NAME=1;
	const INVALID_FIRST_NAME=2;
	const INVALID_PSEUDO=3;
	const INVALID_MAIL=4;
	const INVALID_PASSWORD=5;

	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth']===true;
	}

    public function isAdmin()
    {
        return isset($_SESSION['admin']) && $_SESSION['admin']===true;
	}
	public function validForm()
	{
		return empty($this->errors);
	}

	public function isValid()
	{
		return $this->valid;
	}

	public function connect()
	{
		$_SESSION['auth']=true;
		$_SESSION['id']=$this->id;
		$_SESSION['pseudo']=$this->pseudo();
        if ($this->roleId == 1) {
            $_SESSION['admin'] = true;
        }
	}

	public function disconnect()
	{
		session_destroy();
		unset($_COOKIE['mail']);
		unset($_COOKIE['pass']);
        setcookie('mail', '', time() - 4200, null, null, false, true);
        setcookie('pass', '', time() - 4200, null, null, false, true);
	}

	public function setId($id)
	{
		$id=(int)$id;
		$this->id=$id;
		
	}

	public function setName($name)
	{
		if(!is_string($name) || !ctype_alpha($name))
		{
			$this->errors[]=self::INVALID_NAME;
		}

		$this->name=$name;
	}

	

	public function setFirstName($firstName)
	{
		if(!is_string($firstName) || is_int($firstName))
		{
			$this->errors[]=self::INVALID_FIRST_NAME;
		}

		$this->firstName=$firstName;
	}

	public function setPseudo($pseudo)
	{
		if(!is_string($pseudo))
		{	
			$this->errors[]=self::INVALID_PSEUDO;
		}
		$this->pseudo=$pseudo;
	}

	public function setMail($mail)
	{
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
		{
			$this->errors[]=self::INVALID_MAIL;
		}

		$this->mail=$mail;
	}

	public function setPassword($password)
	{
		if(strlen($password)<8 | !preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $password))
		{
			$this->errors[]=self::INVALID_PASSWORD;
		}
		
		$this->password=$password;

	}

	
	public function setValid(bool $valid)
	{
		$this->valid=$valid;
	}

	public function name()
	{
		return $this->name;
	}

	public function firstName()
	{
		return $this->firstName;
	}

	public function pseudo()
	{
		return $this->pseudo;
	}

	public function mail()
	{
		return $this->mail;
	}

	public function password()
	{
		return $this->password;
	}

    public function RoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $roleId=(int) $roleId;
        $this->roleId = $roleId;
        return $this;
    }



	public function errors()
	{
		return $this->errors;
	}

}