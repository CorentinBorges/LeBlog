<?php
namespace Framework;

Class Managers extends AppComponent
{
	protected $managers=[];

	public function getManagerOf($module,$api)
	{
		if(!is_string($module) || !is_string($api))
		{
			throw new \InvalidArgumentException("L'api et le module doivent être des chaînes de caractères valides");
		}

		if(!isset($this->managers[$module]))
		{
			$this->addManager($module,$api);
		}
		return $this->managers[$module];
	}

	private function addManager($module,$api)
	{
		$className=ucfirst($module).'Manager'.$api;
		if(!file_exists(__DIR__.'/../Models/'.$className.'.php'))
		{
			throw new \InvalidArgumentException("La classe appelée par Managers::addManager n'existe pas");
		}
		$class='Models\\'.$className;

		$this->managers[$module]=new $class(lcfirst($module));
	}
}