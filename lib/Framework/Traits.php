<?php

trait hydrate
{
	foreach ($datas as $attribute=>$value)
		{		
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