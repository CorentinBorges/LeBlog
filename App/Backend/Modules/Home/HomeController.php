<?php
namespace App\Backend\Modules\Home;

use Framework\BackController;
use Framework\HTTPResponse;
use Framework\HTTPRequest;

class HomeController extends BackController
{
	public function executeHome(HTTPRequest $request, HTTPResponse $response)
	{
		$comManager=$this->managers->getManagerOf('comment','PDO');
		$countCom=$comManager->count('valid',0);
		$this->page->addVar('countCom',$countCom);

		$logManager=$this->managers->getManagerOf('users','PDO');
		$countLog=$logManager->count('valid',0);
		$this->page->addVar('countLog',$countLog);
		

		$response->send();
	}
}