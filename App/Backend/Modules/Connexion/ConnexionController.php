<?php 
namespace App\Backend\Modules\Connexion;


use Framework\BackController;
use Framework\HTTPResponse;
use Framework\HTTPRequest;

class ConnexionController extends BackController
{
	public function executeConnexion(HTTPRequest $request, HTTPResponse $response)
	{
		$response->send();
	}
}