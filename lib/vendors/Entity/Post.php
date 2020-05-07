<?php
namespace Entity;

use Framework\Entity;

Class Post extends Entity
{
	protected 	$author,
				$title,
				$chapo,
				$content,
				$dateCreation,
				$dateModif;

	const INVALID_TITLE=1;
	const INVALID_CHAPO=2;
	const INVALID_CONTENT=3;


	public function isValid()
	{
		return !empty($this->title) || !empty($this->chapo) || !empty($this->content);
	}

	public function setAuthor($author)
	{
		if(!is_string($author))
		{
			throw new \InvalidArgumentException("l'auteur doit être une chaîne de caractères valide");
		}
		$this->author=$author;
	}

	public function setTitle($title)
	{
		if (!is_string($title))
		{
			$this->erreurs[]=self::INVALID_TITLE;
		}
		$this->title=$title;
	}

	public function setChapo($chapo)
	{
		if (!is_string($chapo))
		{
			$this->erreurs[]=self::INVALID_CHAPO;
		}

		$this->chapo=$chapo;
	}

	public function setContent($content)
	{
		if (!is_string($content))
		{
			$this->erreurs[]=self::INVALID_CHAPO;
		}

		$this->content=$content;
	}

	
	public function setDateCreation(\DateTime $dateCreation)
	{
		$date=$dateCreation->format('j/m/Y');
		$this->dateCreation=$date;
	}
	
	public function setDateModif(\DateTime $dateModif)
	{
		$date=$dateModif->format('j/m/Y');
		$this->dateModif=$date;
	}

	public function title()
	{
		return $this->title;
	}

	public function chapo()
	{
		return $this->chapo;
	}

	public function content()
	{
		return $this->content;
	}

	public function dateCreation()
	{
		return $this->dateCreation;
	}

	public function dateModif()
	{
		return $this->dateModif;
	}

	public function auteur()
	{
		return $this->auteur;
	}

}