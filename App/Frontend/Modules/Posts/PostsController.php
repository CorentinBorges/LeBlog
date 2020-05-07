<?php
namespace App\Frontend\Modules\Posts;

use Framework\Application;
use Framework\BackController;
use Framework\HTTPRequest;
use Framework\HTTPResponse;

class PostsController extends BackController
{
	public function executeIndex(HTTPRequest $request, HTTPResponse $response)
	{
		$manager=$this->managers->getManagerOf('Posts','PDO');
		$list=$manager->getList();

		$this->page->addVar('list',$list);
		$response->send();
	}

	public function executeOnePost(HTTPRequest $request, HTTPResponse $response)
	{
		$postManager=$this->managers->getManagerOf('Posts','PDO');
		$post=$postManager->getOne($request->getData('id'));
		if(!$post)
		{
			$response->redirect404();
		}
		$this->page->addVar('post',$post);
		$response->send();
	}
}