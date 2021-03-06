<?php

namespace App\Frontend;

use Framework\Application;
use Entity\User;

use App\Frontend\Modules\Users\UsersController;

class FrontendApplication extends Application
{
	protected $user;

	public function __construct()
	{
		parent::__construct();
		$this->user=new User();
		$this->name='Frontend';
	}

	public function run()
	{
		
		if(isset($_COOKIE['mail']) && isset($_COOKIE['pass']) && !$this->user->isAuthenticated())
		{
			$logController=new UsersController($this,'connect','Users');
			$logController->execute();
		}
		
		$controller=$this->getController();
		if($this->user->isAuthenticated())
		{
			$controller->page()->addVar('connected','connected');
			$controller->page()->addVar('pseudo',$_SESSION['pseudo']);
		}
        if($this->user->isAdmin())
        {
            $controller->page()->addVar('admin','admin');
        }

		
		$controller->execute();
	}

	public function setUser(User $user)
	{
		$this->user=$user;
	}

	public function user()
	{
		return $this->user;
	}
}