<?php
namespace App\Frontend\Modules\Errors;

use Framework\BackController;
use Framework\HTTPRequest;
use Framework\HTTPResponse;

class ErrorsController extends BackController
{
	public function execute404(HTTPRequest $request, HTTPResponse $response)
	{
		header('HTTP/1.0 404 Not Found');
		$response->send();
	}
}