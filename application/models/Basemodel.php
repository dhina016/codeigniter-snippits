<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basemodel extends CI_Model
{

    public function __construct()
	{
		parent::__construct();

        $this->db->db_select(DATABASE_NAME);
	} 

    public $tablename = "";
    public $jointable = "";

    public function getSingleData($condition='', $selectedValue='*')
    {

        if ($condition != '') {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename)
                ->where($condition);
        } else {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename);
        }

        return $query->get()->row();
    }

    public function getMultipleData($condition='', $selectedValue='*', $limit=0, $offset=0)
    {
        if ($limit == 0) {
            if ($condition != '') {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->where($condition);
            } else {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename);
            }
        } else {
            if ($condition != '') {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->where($condition)
                    ->limit($limit, $offset);
            } else {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->limit($limit, $offset);
            }
        }

        return $query->get()->result();
    }

    
    public function getSingleDataJoin( $condition, $selectedValue='*')
    {
        $this->db->select($selectedValue);
        $this->db->from($this->tablename);
        $this->db->join($this->jointable, $condition);
        $query = $this->db->get();

        return $query->row();
    }

    public function getMultipleDataJoin($condition, $selectedValue='*')
    {
        $this->db->select($selectedValue);
        $this->db->from($this->tablename);
        $this->db->join($this->jointable, $condition);
        $query = $this->db->get();

        return $query->result();
    }

    
    public function getSingleDataLike($condition='', $selectedValue='*')
    {
        if ($condition != '') {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename)
                ->like($condition);
        } else {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename);
        }

        return $query->get()->row();
    }
    
    public function getMultipleDataLike($condition='', $selectedValue='*')
    {
        if ($condition != '') {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename)
                ->like($condition);
        } else {
            $query = $this->db->select($selectedValue)
                ->from($this->tablename);
        }

        return $query->get()->result();
    }

    public function insertData($data)
    {
        $this->db->insert($this->tablename, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function updateData($condition, $data)
    {
        $this->db->where($condition);
        $this->db->update($this->tablename, $data);

        if($this->db->affected_rows()){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function login($column, $data)
	{
		$user = $data['username'];
        $password = $data['password'];
        $myquery = $this->db->select('*')
                            ->from($this->tablename)
                            ->where($column, $user);
        $rows = $myquery->row();
		if (isset($rows)) {
			$hash = $rows->password;
			if (md5($password) == $hash) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}
