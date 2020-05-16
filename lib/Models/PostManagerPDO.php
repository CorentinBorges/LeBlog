<?php

namespace Models;

use Framework\PDOManager;
use Entity\Post;

class PostManagerPDO extends PDOManager
{
	public function getList()
	{
        $req=$this->createQuery("SELECT id,title,chapo,content,date_creation,date_modif,author FROM post");
		$posts=$req->fetchAll();
		foreach ($posts as $key=>$post)
		{
			$post['date_creation']=new \DateTime($post['date_creation']);
			if(isset($post['date_modif']))
			{
				$post['date_modif']=new \DateTime($post['date_modif']);
			}
			$posts[$key]=new Post($post);
		}
		return $posts;
	}

	public function getOne($id)
	{
        $id = (int)$id;
		$request=$this->createQuery("SELECT * FROM post WHERE id= ?",[$id]);

		$post=$request->fetch(\PDO::FETCH_ASSOC);
		if($post)
		{
			$post['date_creation']= new \DateTime($post['date_creation']);
			$post['date_modif']= isset($post['date_modif']) ? new \DateTime($post['date_modif']) : null;
			$post=new Post($post);
		}
		return $post;
	}
}