<?php

namespace App\Backend;

use Framework\Application;
use Entity\User;

class BackendApplication extends Application
{
	public function __construct()
	{
		parent::__construct();
		$this->name='Backend';
		$this->user=new User();
	}
	public function run()
	{
		

		if ($this->user->isAdmin() || (isset($_COOKIE['loginAdmin']) && isset($_COOKIE['passAdmin'])))
		{
			$controller=$this->getController();
		}
		else
		{
			$controller=new Modules\Connexion\ConnexionController($this,'Connexion','connexion');
		}

		if($this->user->isAuthenticated())
		{
			$controller->page()->addVar('connected','connected');
			$controller->page()->addVar('pseudo',$_SESSION['pseudo']);
		}

		$controller->execute();
	}
}