<?php

namespace Models;

use Framework\PDOManager;
use Entity\User;

class LogsManagerPDO extends PDOManager
{
	public function addLogs(User $user)
	{
		$req='INSERT INTO users(mail,password,name,first_name,pseudo, role_id) VALUES ( :mail, :password, :name, :first_name, :pseudo, :role_id)';

		
		$password=password_hash($user->password(), PASSWORD_BCRYPT, array('cost'=>12));
		$request=$this->db->prepare($req);
		$request->bindValue(':mail',$user->mail(),\PDO::PARAM_STR);
		$request->bindValue(':password',$password,\PDO::PARAM_STR);
		$request->bindValue(':name',$user->name(),\PDO::PARAM_STR);
		$request->bindValue(':first_name',$user->firstName(),\PDO::PARAM_STR);
        $request->bindValue(':pseudo',$user->pseudo(),\PDO::PARAM_STR);
        $request->bindValue(':role_id',2,\PDO::PARAM_INT);

        $request->execute();

	}

	public function exist($column,$data)
	{
		$req=$this->db->query('SELECT COUNT(*) FROM users WHERE '.$column.' = "'.$data.'"')->fetch();
		return $req[0]==0 ? false : true;
	}

	public function getOne($mail)
	{
		$req=$this->db->prepare('SELECT * FROM users WHERE mail= :mail');
		$req->bindValue(':mail',$mail,\PDO::PARAM_STR);
		$req->execute();
		$user=$req->fetch(\PDO::FETCH_ASSOC);

		$user['valid']=(int)$user['valid'];

		$user['valid']=$user['valid']===0 ? false : true;
		return new User($user);
	}

	public function getPass($mail)
	{
		$req=$this->db->prepare('SELECT password FROM users WHERE mail= :mail');
		$req->bindValue(':mail',$mail,\PDO::PARAM_STR);
		$req->execute();
		$pass=$req->fetch();
		return $pass[0];
	}

	public function count($column,$value)
	{
		$req=$this->db->query('SELECT COUNT(*) FROM users WHERE '.$column.' = "'.$value.'"')->fetch();
		return $req[0];
	}
}