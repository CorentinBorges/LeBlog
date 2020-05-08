<?php
namespace App\Frontend\Modules\Log;

use Framework\HTTPRequest;
use Framework\HTTPResponse;
use Framework\BackController;
use Entity\User;

class LogController extends BackController
{
	public function executeSignIn(HTTPRequest $request, HTTPResponse $response)
	{
		if($request->postExist('submitLog'))
		{
			$logManager=$this->managers->getManagerOf('logs','PDO');
			$errors=[];	
			$red='text-danger';

			$user=new User(['name'=>$request->postData('name'),
							'firstName'=>$request->postData('firstName'),
							'pseudo'=>$request->postData('pseudo'),
							'mail'=>$request->postData('mail'),
							'password'=>$request->postData('pass'),
							]);

			if(!preg_match('#^'.$request->postData('pass').'$#',$request->postData('confirmPass')))
			{
				$errors[]="Vous avez entré 2 mots de passe différents";
				$this->page->addVar('invalidConfirm',$red);
			}

			if($logManager->exist('pseudo',$request->postData('pseudo')))
			{
				$errors[]="Ce nom d'utilisateur n'est pas disponible";
				$this->page->addVar('invalidPseudo',$red);
			}

			if(!$request->postExist('conditions'))
			{
				$errors[]="Vous ne pouvez pas vous inscrire sans accepter les conditions d'utilisation";
			}

			if($logManager->exist('mail',$request->postData('mail')))
			{
				$errors[]="Quelqu'un est déjà inscrit avec cet e-mail";
				$this->page->addVar('invalidMail',$red);
			}

			if($user->validForm() && empty($errors))
			{
				$logManager->addLogs($user);
				$response->redirect('/blog/validSignIn');
			}
			else
			{
				foreach ($_POST as $key => $value) 
				{
					$this->page->addVar($key,$value);
				}

				if (in_array(User::INVALID_NAME,$user->errors()))
				{
					$errors[]="Le nom doit être une chaîne de caractères valide";
					$this->page->addVar('invalidName',$red);
				}

				if (in_array(User::INVALID_FIRST_NAME,$user->errors()))
				{
					$errors[]="Le Prénom doit être une chaîne de caractères valide";
					$this->page->addVar('invalidFirstName',$red);

				}

				if (in_array(User::INVALID_PSEUDO,$user->errors()))
				{
					$errors[]="Le pseudo doit être une chaîne de caractère valide";
					$this->page->addVar('invalidPseudo',$red);

				}		

				if (in_array(user::INVALID_MAIL,$user->errors()))
				{
					$errors[]="Le mail doit être un mail valide";
					$this->page->addVar('invalidMail',$red);
				}	

				if (in_array(User::INVALID_PASSWORD,$user->errors()))
				{
					$errors[]="Le mot de passe doit comporter au moins 8 caractères, au moins une majuscule, une minuscule, un signe de ponctuation et un chiffre.";
					$this->page->addVar('invalidPass',$red);
				}	

				$this->page->addVar('errors',$errors);
			}

		}


		$response->send();
	}

	public function executeValidSignIn(HTTPRequest $request, HTTPResponse $response)
	{
		$response->send();
	}

	public function executeLogin(HTTPRequest $request, HTTPResponse $response)
	{
		if($request->postExist('submitConnect'))
		{
			$mail=$request->postData('mail');
			$pass=$request->postData('pass');
			$this->page->addVar('pass',$pass);
			$this->page->addVar('mail',$mail);
			if($request->postExist('cookie'))
			{
				$this->page->addVar('checked','checked');
			}

			$logManager=$this->managers->getManagerOf('logs','PDO');
			

			if($logManager->exist('mail',$mail) && password_verify($pass, $logManager->getPass($mail)))
			{
				$this->app->setUser($logManager->getOne($mail));
				if(!$this->app->user()->isValid())
				{
					$this->page->addVar('error','Votre inscription est en cours de validation');
				}
				else
				{
					if($request->postExist('cookie'))
					{
						setcookie('mail',$mail, time()+365*24*3600, null, null, false, true);
						setcookie('pass',$pass, time()+365*24*3600, null, null, false, true);
					}
					$this->executeConnect($request,$response);
					$response->redirect('/blog');
				}
			}
			else
			{
				$this->page->addVar('error','Le mot de passe ou le mail sont incorrecte');
			}
		}

		$response->send();
	}
	public function executeConnect(HTTPRequest $request, HTTPResponse $response)
	{
		if($request->cookieExist('mail') && $request->cookieExist('pass'))
		{
			$logManager=$this->managers->getManagerOf('logs','PDO');
			$this->app->setUser($logManager->getOne($_COOKIE['mail']));
		}
		$this->app->user()->connect();
	}

	public function executeDisconnect(HTTPRequest $request, HTTPResponse $response)
	{
		$this->app->user()->disconnect();
		$response->redirect('/blog');
	}
}