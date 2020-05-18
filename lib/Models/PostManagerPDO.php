<?php

namespace Models;

use Framework\PDOManager;
use Entity\Post;

class PostManagerPDO extends PDOManager
{
	public function getList()
	{
        $req=$this->createQuery("SELECT id,title,chapo,content,date_creation,date_modif,author FROM post ORDER BY id DESC");
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

    public function add(Post $post)
    {
        $req = 'INSERT INTO post(title,chapo,content,date_creation,author) VALUES(?,?,?,DATE(NOW()),?)';
        $this->createQuery($req, [$post->title(), $post->chapo(), $post->content(), $_SESSION['pseudo'],
        ]);
	}

    public function del($id)
    {
        $req = 'DELETE FROM post WHERE id =?';
        $this->createQuery($req,[$id]);
	}

    public function exist($id)
    {
        $req = "SELECT COUNT(*) FROM post WHERE id =".$id;
        $count=$this->createQuery($req)->fetch();
        return $count[0] == 0 ? false : true;
	}

    public function edit(Post $post)
    {
        $id = (int)$post->id();
        $req = "UPDATE post SET title= ?, chapo= ?, content= ?, date_modif= DATE(NOW()) WHERE id= ?";
        $this->createQuery($req, [$post->title(), $post->chapo(), $post->content(),$id]);
	}
}