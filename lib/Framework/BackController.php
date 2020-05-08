<?php

namespace Framework;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


abstract class BackController extends AppComponent
{
	protected 	$action,
				$module,
				$page,
				$managers,
				$twig,
				$view;

	public function __construct(Application $app,$action, $module, $view=null)
	{
		parent::__construct($app);
		$this->page=new Page($this->app);
		$this->managers=new Managers($this->app);
		$this->setAction($action);
		$this->setModule($module);
		$this->setView($action);
	}

	public function execute()
	{
		$method='execute'.ucfirst($this->action);
		if (!is_callable([$this, $method]))
		{
			throw new \RuntimeException("La méthode demandée par ".$this->module."Controller::run() n'est pas disponible");
		}
		
		$httpRequest=$this->app->httpRequest();
		$this->$method($httpRequest,$this->app->HTTPResponse());
	}

	public function setAction($action)
	{
		if(!is_string($action) || empty($action))
		{
			throw new \InvalidArgumentException("L'action doit être une chaîne de caractères valide");
		}

		$this->action=$action;
	}

	public function setmodule($module)
	{
		if(!is_string($module) || empty($module))
		{
			throw new \InvalidArgumentException("Le module doit être une chaîne de caractères valide");
		}
		$this->module=$module;
	}

	public function setView($view)
	{
		if(!is_string($view))
		{
			throw new \InvalidArgumentException("La vue doit être une chaine de caractères valide");
		}

		$this->app->httpResponse()->setPage($this->page);
		$this->page->setContent('App/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$view.'.twig');
	}

	public function page()
	{
		return $this->page;
	}

}