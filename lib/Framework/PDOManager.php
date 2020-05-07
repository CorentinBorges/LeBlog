<?php

namespace Framework;

class PDOManager
{
	protected $db;

	public function __construct()
	{
		$this->db=PDOFactory::getPDO();
	}

}