<?php

namespace Models;

use Framework\PDOManager;
use Entity\Post;

class PostsManagerPDO extends PDOManager
{
	public function getList()
	{
		$q="SELECT id,title,chapo,content,date_creation,date_modif,author FROM post";

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

	public function getOne($id)
	{
		$request="SELECT * FROM post WHERE id= :id";
		$req=$this->db->prepare($request);
		$req->bindValue(":id",(int)$id,\PDO::PARAM_INT);
		$req->execute();
		$post=$req->fetch(\PDO::FETCH_ASSOC);
		if($post)
		{
			$post['date_creation']= new \DateTime($post['date_creation']);
			$post['date_modif']= isset($post['date_modif']) ? new \DateTime($post['date_modif']) : null;
			$post=new Post($post);
		}
		
		return $post;
	}
}