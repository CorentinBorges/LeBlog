<?php


namespace App\Backend\Modules\Post;

use Framework\HTTPResponse;
use Framework\HTTPRequest;

class PostController extends \Framework\BackController
{
    public function executeIndex(HTTPRequest $request, HTTPResponse $response)
    {
        $manager=$this->managers->getManagerOf('Post','PDO');
        $list=$manager->getList();
        $this->page->addVar('list',$list);
        $response->send();
    }


}