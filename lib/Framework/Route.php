<?php
namespace Framework;

class Route
{
	protected 	$url,
				$module,
				$varsNames,
				$vars=[],
				$action;

	public function __construct($url,$module,$action,array $varsNames=[])
	{
		$this->setUrl($url);
		$this->setModule($module);
		$this->setAction($action);
		$this->setVarsNames($varsNames);

	}

	public function match($url)
	{
		if(preg_match('#^'.$this->url.'$#', $url,$matched))
		{
			return $matched;
		}
		return false;
	}

		public function hasVars()
	{
		return !empty($this->varsNames());
	}

	public function setUrl($url)
	{
		if(!is_string($url) || empty($url))
		{
			throw new \InvalidArgumentException("l'url doit être une chaîne de caractère valide");
		}

		$this->url=$url;
	}

	public function setModule($module)
	{
		if(!is_string($module) || empty($module))
		{
			throw new \InvalidArgumentException("le model doit être une chaîne de caractère valide");
		}

		$this->module=$module;
	}

	public function setVarsNames(array $varsNames)
	{
		foreach ($varsNames as $varName)
		{
			if(!is_string($varName))
			{
				throw new \InvalidArgumentException("Les variables doivent êtres des chaines de caractères valides");	
			}
		}

		$this->varsNames=$varsNames;
	}

	public function setAction($action)
	{
		if(!is_string($action) || empty($action))
		{
			throw new \InvalidArgumentException("l'action doit être une chaîne de caractère valide");
		}

		$this->action=$action;
	}



	public function addVars(Array $vars)
	{
		if (empty($vars))
		{
			throw new InvalidArgumentException("Le tableau des variables ajoutées à une route doit contenir des valeurs");
		}

		$this->vars=$vars;
	}

	public function vars()
	{
		return $this->vars;
	}

	public function varsNames()
	{
		return $this->varsNames;
	}

	public function url()
	{
		return $this->url;
	}

	public function module()
	{
		return $this->module;
	}

	public function action()
	{
		return $this->action;
	}



}