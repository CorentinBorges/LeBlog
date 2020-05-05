<?php
namespace App\Frontend\Modules\Home;


use Framework\BackController;
use Framework\HTTPRequest;
use Framework\HTTPResponse;
use Framework\Mail;

class HomeController extends BackController
{
	public function executeIndex(HTTPRequest $request, HTTPResponse $response)
	{

		if($request->postExist('submit'))
		{ 
			$mail=new Mail(['name'=>$request->postData('name'),
							'firstName'=>$request->postData('first-name'),
							'obj'=>$request->postData('obj'),
							'message'=>$request->postData('message'),
							'mail'=>$request->postData('mail')]);

			if($mail->isValid())
			{
				$response->sendMail($mail);
				$this->page->addVar('confirm','confirm');
			}

			else
			{
				$errors=[];
				if (in_array(Mail::INVALID_NAME,$mail->errors()))
				{
					$errors[]="Le nom doit être une chaîne de caractères valide";
				}

				if (in_array(Mail::INVALID_FIRST_NAME,$mail->errors()))
				{
					$errors[]="Le Prénom doit être une chaîne de caractères valide";
				}

				if (in_array(Mail::INVALID_OBJ,$mail->errors()))
				{
					$errors[]="L'objet doit être une chaîne de caractère valide";
				}		

				if (in_array(Mail::INVALID_MESSAGE,$mail->errors()))
				{
					$errors[]="Le message doit être une chaîne de caractère valide";
				}	

				if (in_array(Mail::INVALID_MAIL,$mail->errors()))
				{
					$errors[]="Le mail doit être un mail valide";
				}	

				$this->page->addVar('errors',$errors);		
				
			}
			
		}
		$response->send();
	}


	public function executeCV(HTTPRequest $request, HTTPResponse $response)
	{
		
		$response->send();
	}
}
