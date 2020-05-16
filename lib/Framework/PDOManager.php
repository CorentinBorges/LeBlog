<?php

namespace Framework;

class PDOManager
{
	protected   $db,
                $table;

	public function __construct($model)
	{
        $this->table = $model;
		$this->db=PDOFactory::getPDO();
	}

    public function createQuery($query,$parameters=null)
    {
        if (isset($parameters)) {
            $req = $this->db->prepare($query);
            $req->execute($parameters);
            return $req;
        }
        else {
            $req = $this->db->query($query);
            return $req;
        }
	}

    public function count($column,$value)
    {
        $query = 'SELECT COUNT(*) FROM '.$this->table.' WHERE '.$column.' = '.$value;
        $req=$this->db->query($query)->fetch();
        return $req[0];
	}
}