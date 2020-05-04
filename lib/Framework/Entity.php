<?php

namespace Framework;

class Entity
{
	protected 	$id,
				$erreurs=[];

	public function __construct(Array $datas)
	{
		$this->hydrate($datas);
	}

	public function hydrate(array $datas)
	{
		foreach ($datas as $attribute=>$value)
		{
			if(preg_match("#._.#", $attribute))
			{
				$attrWords=explode("_", $attribute);
				foreach ($attrWords as $key=>$word)
				{
					$attrWords[$key]=ucfirst($word);
				}
				$attribute=implode("", $attrWords);
			}
				
			if(is_string($attribute) && isset($value))
			{
				$method='set'.ucfirst($attribute);
				if(!is_callable([$this,$method]))
				{
					throw new \RuntimeException("La méthode ".$method." n'éxiste pas");
				}
				$this->$method($value);
			}
		}
	}

	public function setId($id)
	{
		$id= (int) $id;
		$this->id=$id;
	}

	public function id()
	{
		return $this->id;
	}
}