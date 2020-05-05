<?php
namespace Framework;

/**
 * 
 */
class mail 
{
	protected 	$name,
				$firstName,
				$obj,
				$message,
				$mail,
				$errors=[];

	const INVALID_NAME=1;
	const INVALID_FIRST_NAME=2;
	const INVALID_OBJ=3;
	const INVALID_MESSAGE=4;
	const INVALID_MAIL=5;

	public function __construct(array $datas)
	{
		$this->hydrate($datas);
	}


	public function hydrate(array $datas)
	{
		foreach ($datas as $attribute=>$value)
		{		
			if(is_string($attribute) && isset($value))
			{
				$method='set'.ucfirst($attribute);
				if(!is_callable([$this,$method]))
				{
					throw new \RuntimeException("La méthode ".$method." n'éxiste pas");
				}
				$this->$method($value);
			}
		}
	}


	public function isValid()
	{
		return empty($this->errors);
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

	public function setObj($obj)
	{
		if(!is_string($obj))
		{
			$this->errors[]=self::INVALID_OBJ;
		}

		$this->obj=$obj;
	}

	public function setMessage($message)
	{
		if(!is_string($message))
		{
			$this->errors[]=self::INVALID_MESSAGE;
		}

		$this->message=$message;
	}

	public function setMail($mail)
	{
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
		{
			$this->errors[]=self::INVALID_MESSAGE;
		}

		$this->mail=$mail;
	}

	public function name()
	{
		return $this->name;
	}

	public function firstName()
	{
		return $this->firstName;
	}

	public function obj()
	{
		return $this->obj;
	}

	public function message()
	{
		return $this->message;
	}

	public function adress()
	{
		return $this->adress;
	}

	public function mail()
	{
		return $this->mail;
	}

	public function errors()
	{
		return $this->errors;
	}

}

