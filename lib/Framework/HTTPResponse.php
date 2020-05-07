<?php
namespace Framework;

use Framework\appComponent;
use Framework\Mail;

Class HTTPResponse extends appComponent
{
	protected $page;

	public function redirect($path)
	{
		header('Location: '.$path);
		exit;
	}

	public function setPage(Page $page)
	{
		$this->page=$page;
	}
	
	public function redirect404()
	{
		$this->redirect('/blog/404');

	}

	public function sendMail(Mail $mail)
	{

		$jsonFile=file_get_contents(__DIR__.'/../../App/'.$this->app->name().'/Config/app.Json');
		$json=json_decode($jsonFile,true);
		$to=$json['mail'];
		$obj=$mail->firstName().' '.$mail->name().' : '.$mail->obj();
		$headers =	'From: '.$mail->mail() . "\r\n" .
					'Reply-To: '.$mail->mail(). "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

		mail($to,$obj,$mail->message(),$headers);
	}

	public function send()
	{ 
		exit ($this->page->getGeneratedPage());
	}

}