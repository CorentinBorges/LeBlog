<?php
namespace Framework;

class ParserXML
{
	protected $path;

	public function __construct($path)
	{
		$this->setPath($path);
	}

	public function getVars($tagName)
	{
		$xml=new \DOMDocument;
		$xml->load($this->path);
		$vars=$xml->getElementsByTagName($tagName);
		return $vars;
	}

	public function setPath($path)
	{
		if(!is_string($path))
		{
			throw new InvalidArgumentException("Le chemin indiquer pour le fichier xml doit être une chaîne de caractères valide");
		}

		$this->path=$path;
	}

	public function path()
	{
		if(!file_exists($this->path))
		{
			throw new InvalidArgumentException("Le fichier XML que vous demandez de parser n'xiste pas");
		}

		return $this->path;
	}
}