<?php

namespace Models;

use Framework\PDOManager;
use Entity\User;

class LogsManagerPDO extends PDOManager
{
	public function addLogs(User $user)
	{
		$req='INSERT INTO users(id,mail,password,name,first_name,pseudo) VALUES (:id, :mail, :password, :name, :first_name, :pseudo)';

		$id=$this->maxId()==null ? 0 : $this->maxId()+1;
		

		$request=$this->db->prepare($req);
		$request->bindValue(':id',$id,\PDO::PARAM_INT);
		$request->bindValue(':mail',$user->mail(),\PDO::PARAM_STR);
		$request->bindValue(':password',$user->password(),\PDO::PARAM_STR);
		$request->bindValue(':name',$user->name(),\PDO::PARAM_STR);
		$request->bindValue(':first_name',$user->firstName(),\PDO::PARAM_STR);
		$request->bindValue(':pseudo',$user->pseudo(),\PDO::PARAM_STR);
		$request->execute();

	}

	public function maxId()
	{
		$max=$this->db->query("SELECT MAX(id) FROM users")->fetch();
		return $max[0];
	}

	public function exist($column,$data)
	{
		$req=$this->db->query('SELECT COUNT(*) FROM users WHERE '.$column.' = "'.$data.'"')->fetch();
		return $req[0]==0 ? false : true;
	}
}