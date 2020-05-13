<?php

namespace Entity;

use Framework\Entity;

class Comment extends Entity
{
	protected 	$userId,
				$postId,
				$content,
				$date,
				$author,
				$valid;

const INVALID_COMMENT=1;

	public function isValid()
	{
		return $this->valid;
	}

	public function validForm()
	{
		return empty($this->errors);
	}

	public function setUserId($userId)
	{
		$userId=(int)$userId;
		$this->userId=$userId;
	}

	public function setPostId($postId)
	{
		$postId=(int)$postId;
		$this->postId=$postId;
	}

	public function setAuthor($author)
	{
		if(!is_string($author))
		{
			throw new \InvalidArgumentException("L'auteur du commentaire doit être une chaîne de caractère valide");
		}

		$this->author=$author;
	}

	public function setContent($content)
	{
		if(strlen($content)>250)
		{
			$this->errors[]=self::INVALID_COMMENT;
		}
		$this->content=$content;
	}

	public function setValid(bool $valid=false)
	{
		$this->valid=$valid;
	}

	public function setDate(\DateTime $date)
	{
		$newDate=$date->format('j/m/Y');
		$this->date=$newDate;
	}


	public function userId()
	{
		return $this->userId;
	}

	public function postId()
	{
		return $this->postId;
	}

	public function content()
	{
		return $this->content;
	}

	public function date()
	{
		return $this->date;
	}

	public function author()
	{
		return $this->author;
	}

	
}