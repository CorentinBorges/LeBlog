<?php


namespace App\Backend\Modules\Post;

use Entity\Post;
use Framework\Application;
use Framework\HTTPResponse;
use Framework\HTTPRequest;

class PostController extends \Framework\BackController
{
    protected $postManager;

    public function __construct(Application $app, $action, $module, $view = null)
    {
        parent::__construct($app, $action, $module, $view);
        $this->postManager=$this->managers->getManagerOf('post','PDO');
    }

    public function executeIndex(HTTPRequest $request, HTTPResponse $response)
    {
        $list=$this->postManager->getList();
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
                $this->postErrors($post, $post->errors(), $request);
            }
            else{
                $this->postManager->add($post);
                $response->redirect('/blog/admin/posts');
            }

        }
        $response->send();
    }

    public function executeDelPost(HTTPRequest $request, HTTPResponse $response)
    {
        $tab = explode('-',$request->postData('delete'));
        $id = $tab[1];
        $this->postManager->del($id);
        $response->redirect('/blog/admin/posts');
    }

    public function executeEditPost(HTTPRequest $request, HTTPResponse $response)
    {
        if ($request->postExist('submitPost')) {
            $post = new Post([
                'id' => $request->getData('postId'),
                'title' => $request->postData('title'),
                'chapo' => $request->postData('chapo'),
                'content' => $request->postData('content')]);
            if (empty($post->errors())) {
                echo $post->id();
                $this->postManager->edit($post);
                $response->redirect('/blog/admin/posts');
            } else {
                $this->postErrors($post, $post->errors(), $request);
            }
        }
        if ($this->postManager->exist($request->getData('postId'))) {
            $post=$this->postManager->getOne($request->getData('postId'));
            $this->page->addVar('post', $post);
            $response->send();
        }
        else{
            $response->redirect('/blog/404');
        }

    }


    public function postErrors(Post $post, array $errors, HTTPRequest $request)
    {
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

}