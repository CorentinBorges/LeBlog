<?php
namespace App\Frontend\Modules\Home;

use Framework\Application;
use Framework\BackController;
use Framework\HTTPRequest;
use Framework\HTTPResponse;

class HomeController extends BackController
{
	public function executeIndex(HTTPRequest $HTTPRequest, HTTPResponse $HTTPResponse)
	{
		$manager=$this->app->managers()->getManagerOf('Posts','PDO');
		$listObj=$manager->getList();
		$list=[];
		foreach ($listObj as $key=>$post)
		{
			$list[$key]=[	'title'=>$post->title(),
							'chapo'=>$post->chapo(),
							'auteur'=>$post->auteur(),
							'content'=>$post->content(),
							'dateCreation'=>$post->dateCreation(),
							'dateModif'=>$post->dateModif()];
		}


		$this->page->addVars('list',$list);
		$HTTPResponse->send();
	}
}