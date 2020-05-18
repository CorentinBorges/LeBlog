<?php


namespace App\Backend\Modules\Post;

use Entity\Post;
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

    public function executeAddPost(HTTPRequest $request, HTTPResponse $response)
    {
        if ($request->postExist('submitPost')) {

            $post = new Post([  'title' => $request->postData('title'),
                                'chapo'=>$request->postData('chapo'),
                                'content'=>$request->postData('content')]);
            if(!empty($post->errors())) {
                if ($post::INVALID_TITLE) {
                    $errors[] = "Le titre n'est pas valide";
                    $this->page->addVar('title', $request->postData('title'));
                }
                if ($post::INVALID_CHAPO) {
                    $errors[] = "Le chapo n'est pas valide";
                    $this->page->addVar('chapo', $request->postData('chapo'));

                }
                if ($post::INVALID_CONTENT) {
                    $errors[] = "Le contenu de l'article n'est pas valide";
                    $this->page->addVar('content', $request->postData('content'));
                }
                $this->page->addVar('errors', $errors);
            }
            else{
                $manager=$this->managers->getManagerOf('post','PDO');
                $manager->add($post);
                $response->redirect('/blog/admin/posts');
            }

        }
        $response->send();
    }

    public function executeDelPost(HTTPRequest $request, HTTPResponse $response)
    {
        $postManager=$this->managers->getManagerOf('Post','PDO');
        $tab = explode('-',$request->postData('delete'));
        $id = $tab[1];
        $postManager->del($id);
        $response->redirect('/blog/admin/posts');
    }

}