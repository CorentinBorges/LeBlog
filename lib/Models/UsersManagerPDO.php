<?php

namespace Models;

use Framework\PDOManager;
use Entity\User;

class UsersManagerPDO extends PDOManager
{
	public function addLogs(User $user)
	{
		$req='INSERT INTO users(mail,password,name,first_name,pseudo, role_id) VALUES ( ?, ?, ?, ?, ?, ?)';
		$password=password_hash($user->password(), PASSWORD_BCRYPT, array('cost'=>12));
		$this->createQuery($req,[$user->mail(),$password,$user->name(),$user->firstName(),$user->pseudo(),2]);

	}

	public function exist($column,$data)
	{
		$req=$this->db->query('SELECT COUNT(*) FROM users WHERE '.$column.' = "'.$data.'"')->fetch();
		return $req[0]==0 ? false : true;
	}

	public function getOne($mail)
	{
        $query= 'SELECT * FROM users WHERE mail= ?';
		$req=$this->createQuery($query,[$mail]);
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

}