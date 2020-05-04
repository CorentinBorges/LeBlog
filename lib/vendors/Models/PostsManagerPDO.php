<?php

namespace Models;

use Framework\PDOManager;
use Entity\Post;

class PostsManagerPDO extends PDOManager
{
	public function getList()
	{
		$q="SELECT posts.id,title,chapo,content,date_creation,date_modif,admin.utilisateur AS auteur FROM posts
			JOIN admin ON posts.admin_id=admin.id";

		$request= $this->db->query($q);
		$posts=$request->fetchAll();
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
}