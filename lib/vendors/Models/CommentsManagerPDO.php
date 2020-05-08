<?php

namespace Models;

use Framework\PDOManager;
use Entity\Comment;

class CommentsManagerPDO extends PDOManager
{
	public function addComment(Comment $comment)
	{
		
		$id=$this->maxId()==null ? 0 : $this->maxId()+1;

		$req='INSERT INTO comment(id,user_id,post_id,content,date) VALUES(:id, :user_id, :post_id, :content, DATE(NOW()))';
		$required=$this->db->prepare($req);

		$required->bindValue(':id',(int)$id,\PDO::PARAM_INT);
		$required->bindValue(':user_id',$comment->userId(),\PDO::PARAM_INT);
		$required->bindValue(':post_id',$comment->postId(),\PDO::PARAM_INT);
		$required->bindValue(':content',$comment->content(),\PDO::PARAM_STR);
		$required->execute();
	}

	public function maxId()
	{
		$max=$this->db->query("SELECT MAX(id) FROM comment")->fetch();
		return $max[0];
	}

	public function commentExist($postId)
	{
		$count=$this->db->query('SELECT COUNT(*) FROM comment WHERE (post_id='.$postId.' AND comment.valid=1)')->fetch();
		return $count[0]==0 ? false : true;
	}

	public function getComments($postId)
	{
		$req='SELECT comment.id,user_id,post_id,content,date,comment.valid,users.pseudo AS author FROM comment 
		JOIN users ON users.id=comment.user_id
		WHERE (post_id='.$postId.' AND comment.valid=1) ORDER BY comment.id DESC';
		$request=$this->db->query($req)->fetchAll(\PDO::FETCH_ASSOC);
		$comments=[];
		foreach ($request as $comment) 
		{
			$comment['id']=(int)$comment['id'];
			$comment['user_id']=(int)$comment['user_id'];
			$comment['post_id']=(int)$comment['post_id'];

			$comment['date']=new \DateTime($comment['date']);

			$comment=new Comment($comment);
			$comments[]=$comment;
		}

		return $comments;
	}
}