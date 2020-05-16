<?php

namespace Framework;

use Entity\User;
abstract class Application
{
	protected 	$HTTPRequest,
				$HTTPResponse,
				$user,
				$name;

	public function __construct()
	{
		$this->HTTPRequest=new HTTPRequest($this);
		$this->HTTPResponse= new HTTPResponse($this);
		$this->user=new User();
		$this->name='';
	}

	abstract public function run();

	public function getController()
	{

		$router=new Router;
		$jsonFile=file_get_contents(__DIR__.'/../../App/'.$this->name.'/Config/routes.json');
		$json=json_decode($jsonFile,true);
		foreach ($json['routes'] as $route)
		{ 
			$vars=[];
			if(isset($route['vars']))
			{
				$vars=explode(', ',$route['vars']);
			}

			$router->addRoute(new Route($route['url'],$route['module'],$route['action'],$vars));
			
		}	
		

		try 
			{
				$finalRoute= $router->getRoute($this->HTTPRequest->getURL());
			}

		catch (\RuntimeException $e) 
			{
				if($e->getCode()== Router::NO_ROUTE)
				{
					
					$this->HTTPResponse->redirect404();

				}
			}
			$_GET=array_merge($_GET,$finalRoute->vars());
			$ControllerClass='App\\'.$this->name.'\\Modules\\'.$finalRoute->module().'\\'.$finalRoute->module().'Controller';
			return new $ControllerClass($this,$finalRoute->action(),$finalRoute->module());
	}

	public function setName($name)
	{
		if(!is_string($name))
		{
			throw new \InvalidArgumentException("Le nom de l'application doit être une chaîne de caractère valide");
		}
		$this->name=$name;
	}
	

	public function name()
	{
		return $this->name;
	}

	public function httpRequest()
	{
		return $this->HTTPRequest;
	}

	public function httpResponse()
	{
		return $this->HTTPResponse;
	}

	public function admin()
	{
		return $this->admin;
	}


}