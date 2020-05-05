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
		$manager=$this->app->managers()->getManagerOf('Posts','PDO');
		$list=$manager->getList();

		$this->page->addVar('list',$list);
		$response->send();
	}

	public function executeOnePost(HTTPRequest $request, HTTPResponse $response)
	{
		$postManager=$this->app->managers()->getManagerOf('Posts','PDO');
		$post=$postManager->getOne($request->getData('id'));
		$this->page->addVar('post',$post);
		$response->send();
	}
}