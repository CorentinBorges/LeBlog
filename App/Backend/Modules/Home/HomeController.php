<?php
namespace App\Backend\Modules\Home;

use Framework\BackController;
use Framework\HTTPResponse;
use Framework\HTTPRequest;

class HomeController extends BackController
{
	public function executeHome(HTTPRequest $request, HTTPResponse $response)
	{
		$comManager=$this->managers->getManagerOf('comments','PDO');
		$countCom=$comManager->count('valid',0);
		$this->page->addVar('countCom',$countCom);

		$logManager=$this->managers->getManagerOf('logs','PDO');
		$countLog=$logManager->count('valid',0);
		$this->page->addVar('countLog',$countLog);
		

		$response->send();
	}
}