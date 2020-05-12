<?php 
namespace App\Backend\Modules\Connexion;


use Framework\BackController;
use Framework\HTTPResponse;
use Framework\HTTPRequest;

class ConnexionController extends BackController
{
	public function executeConnexion(HTTPRequest $request, HTTPResponse $response)
	{
		if($request->getExist('disconnect'))
		{
			$this->app->admin()->disconnect();
		}

		if($request->postExist('submitConnect'))
		{
			$loginAdmin=$request->postData('loginAdmin');
			$passAdmin=$request->postData('passAdmin');
			$this->page->addVar('passAdmin',$passAdmin);
			$this->page->addVar('loginAdmin',$loginAdmin);
			if($request->postExist('cookie'))
			{
				$this->page->addVar('checked','checked');
			}

			$jsonFile=file_get_contents(__DIR__.'/../../Config/app.JSON');
			$json=json_decode($jsonFile,true);

			if($json['adminLog']==$loginAdmin && password_verify($passAdmin, $json['pass']))
			{
				if($request->postExist('cookie'))
				{
					setcookie('loginAdmin',$loginAdmin, time()+365*24*3600, null, null, false, true);
					setcookie('passAdmin',$passAdmin, time()+365*24*3600, null, null, false, true);
				}
				$this->executeConnectAdmin($request,$response);
				$response->redirect('admin');
			}
			else
			{
				$this->page->addVar('error',"Le mot de passe ou le nom d'utilisateur sont incorrecte");
			}
		}

		$response->send();
	}

	public function executeConnectAdmin()
	{
		$this->app->admin()->setAuthentified(true);
	}

	public function executeDisconnect(HTTPRequest $request, HTTPResponse $response)
	{	
		$this->app->admin()->disconnect();
		$this->page->addVar('disconnect','disconnect');
		$response->send();
	}
}