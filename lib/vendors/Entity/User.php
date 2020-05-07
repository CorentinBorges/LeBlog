<?php

namespace Entity;

session_start();

use Framework\Entity;

class User extends Entity
{
	protected 	$id,
				$name,
				$firstName,
				$pseudo,
				$mail,
				$password,
				$valid,
				$errors=[];

	const INVALID_NAME=1;
	const INVALID_FIRST_NAME=2;
	const INVALID_PSEUDO=3;
	const INVALID_MAIL=4;
	const INVALID_PASSWORD=5;

	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth']===true;
	}

	public function validForm()
	{
		return empty($this->errors);
	}

	public function setId($id)
	{
		$id=int($id);
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
		if(!is_string($firstName) || !ctype_alpha($firstName))
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
		$password=password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
		$this->password=$password;

	}

	
	public function setValid(bool $valid=false)
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

	public function valid()
	{
		return $this->valid;
	}

	public function errors()
	{
		return $this->errors;
	}

}