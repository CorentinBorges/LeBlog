<?php
namespace Framework;

class PDOFactory
{
	public static function getPDO()
	{

		$json=file_get_contents(__DIR__.'/../vendors/Models/Config/db.JSON');
		$parsedJson=json_decode($json,true);
		foreach($parsedJson['PDOdb'] as $data)
		{
			$hostname=$data['hostname'];
			$dbname=$data['dbname'];
			$user=$data['user'];
			$password=$data['password'];
		}
		
		$db=new \PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8',$user,$password);
		$db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}
