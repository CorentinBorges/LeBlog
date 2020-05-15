<?php
namespace App\Frontend\Modules\Posts;

use Framework\Application;
use Framework\BackController;
use Framework\HTTPRequest;
use Framework\HTTPResponse;
use Entity\Comment;

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


		$commentManager=$this->managers->getManagerOf('comments','PDO');

		if($commentManager->commentExist($post->id()))
		{
			$comments=$commentManager->getComments($post->id());
			$this->page->addVar('comments',$comments);	
		}
		if($request->postExist('submitComment'))
		{
			
			$comment=new Comment([	'userId'=>$_SESSION['id'],
									'postId'=>$post->id(),
									'content'=>$request->postData('comment')]);
			if(!$comment->validForm())
			{
				if(in_array(Comment::INVALID_COMMENT,$comment->errors()))
				{	
					$this->page->addVar('error','Le commentaire ne doit pas dépasser 250 caractères');
				}
			}
			else
			{
			    if($this->app->user()->isAdmin())
                {
                    $commentManager->addComment($comment,true);
                }
			    else
                {
                    $commentManager->addComment($comment);
                    $this->page->addVar('commentSent','commentSent');
                }

			}

		}

		$this->page->addVar('post',$post);
		$response->send();
	}
}