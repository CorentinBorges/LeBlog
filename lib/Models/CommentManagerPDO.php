<?php

namespace Models;

use Framework\PDOManager;
use Entity\Comment;

class CommentManagerPDO extends PDOManager
{
	public function addComment(Comment $comment,$admin=false)
	{
        $query = 'INSERT INTO comment(user_id,post_id,content,date,valid) VALUES ( ?, ?, ?, DATE(NOW()), ?)';
        $valid= $admin===true ? 1 : 0;
        $req = $this->createQuery($query,[$comment->userId(),$comment->postId(),$comment->content(),$valid]);
	}

    public function countNoValid()
    {
        $query = 'SELECT COUNT(*) FROM comment WHERE valid = 0';
        $req=$this->db->query($query)->fetch();
        return $req[0];
    }

	public function commentExist($postId)
	{
        $req = 'SELECT COUNT(*) FROM comment WHERE (post_id=' . $postId . ' AND comment.valid=1)';
        $count=$this->createQuery($req)->fetch();
		return $count[0]==0 ? false : true;
	}

	public function getComments($postId)
	{
		$req='SELECT comment.id,user_id,post_id,content,date,comment.valid,users.pseudo AS author FROM comment 
		JOIN users ON users.id=comment.user_id
		WHERE (post_id=? AND comment.valid=?) ORDER BY comment.id DESC';
		$request=$this->createQuery($req,[$postId,1])->fetchAll(\PDO::FETCH_ASSOC);
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