<?php

namespace Framework;

class Router
{
	protected $routes=[];

	const NO_ROUTE=1;

	public function getRoute($url)
	{
		foreach ($this->routes as $route)
		{
			if($matched=$route->match($url))
			{
				if($route->hasVars())
				{
					$matched=$route->match($url);
					$varsNames=$route->varsNames();

					foreach ($varsNames as $key=>$value)
					{
						$vars=[];
						$vars[$value]=$matched[$key+1];	
					}
					$route->addVars($vars);
				}
				return $route;
			}	
		}

		throw new \RuntimeException("La page demandée n'existe pas", self::NO_ROUTE);
	}

	public function addRoute(Route $route)
	{
		$this->routes[$route->url()]=$route;
	}


}