<?php
namespace Framework;

use Framework\appComponent;

Class HTTPResponse extends appComponent
{
	protected $page;

	public function redirect($path)
	{
		header('Location: '.$path);
	}

	public function setPage(Page $page)
	{
		$this->page=$page;
	}
	
	public function redirect404()
	{
		$page=$this->setPage(new Page($this->app));
		$this->page->setContent('Errors/404.twig');
		header('HTTP/1.0 404 Not Found');
		$this->send();
	}

	public function send()
	{ 
			 exit ($this->page->getGeneratedPage());
	}

}