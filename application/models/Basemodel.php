<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basemodel extends CI_Model
{

    public function __construct()
	{
		parent::__construct();

        $this->db->db_select(DATABASE_NAME);
	} 

    // order by syntax "column asc"
    // join syntax "t1.a = t2.a"
    public $tablename = "";
    public $jointable = "";
    public function getSingleData($condition='', $selectedValue='*', $orderby='')
    {

        if ($condition != '') {
            if ($orderby != '') {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->where($condition)
                    ->order_by($orderby);
            } else {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->where($condition);
            }
        } else {
            if ($orderby != '') {
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename)
                    ->order_by($orderby);
            } else {  
                $query = $this->db->select($selectedValue)
                    ->from($this->tablename);
            }
        }

        return $query->get()->row();
    }

    public function getMultipleData($condition='', $selectedValue='*', $limit=0, $offset=0, $orderby='')
    {
        if ($limit == 0) {
            if ($condition != '') {
                if ($orderby != '') {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->where($condition)
                        ->order_by($orderby);
                } else {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->where($condition);
                }
            } else {
                if ($orderby != '') {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->order_by($orderby);
                } else {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename);
                }
            }
        } else {
            if ($condition != '') {
                if ($orderby != '') {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->where($condition)
                        ->limit($limit, $offset)
                        ->order_by($orderby);
                } else {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->where($condition)
                        ->limit($limit, $offset);
                }
            } else {
                if ($orderby != '') {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->limit($limit, $offset)
                        ->order_by($orderby);
                } else {
                    $query = $this->db->select($selectedValue)
                        ->from($this->tablename)
                        ->limit($limit, $offset);
                }
            }
        }

        return $query->get()->result();
    }

    
    public function getSingleDataJoin( $condition, $selectedValue='*', $where="")
    {
        if ($where != '') {
            $this->db->select($selectedValue);
            $this->db->from($this->tablename);
            $this->db->join($this->jointable, $condition);
            $this->db->where($where);
            $query = $this->db->get();
        } else {
            $this->db->select($selectedValue);
            $this->db->from($this->tablename);
            $this->db->join($this->jointable, $condition);
            $query = $this->db->get();
        }

        return $query->row();
    }

    public function getMultipleDataJoin($condition, $selectedValue='*', $where="", $limit='', $like='')
    {
        if ($where != '') {
            if ($limit != '') {
                if ($like != '') {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->where($where);
                    $this->db->limit($limit);
                    $this->db->like($like);
                    $query = $this->db->get();
                } else {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->where($where);
                    $this->db->limit($limit);
                    $query = $this->db->get();
                }
            } else {
                if ($like != '') {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->where($where);
                    $this->db->like($like);
                    $query = $this->db->get();
                } else {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->where($where);
                    $query = $this->db->get();
                }

            }
        } else {
            if ($limit != '') {
                if ($like != '') {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->like($like);
                    $this->db->limit($limit);
                    $query = $this->db->get();
                } else {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->limit($limit);
                    $query = $this->db->get();
                }
            } else {
                if ($like != '') {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $this->db->like($like);
                    $query = $this->db->get();
                } else {
                    $this->db->select($selectedValue);
                    $this->db->from($this->tablename);
                    $this->db->join($this->jointable, $condition);
                    $query = $this->db->get();
                }
            }
        }

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

    public function insertBatchData($data)
    {
        $this->db->insert_batch($this->tablename, $data);
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

    public function deleteData($condition)
    {
        $this->db->where($condition);
        $this->db->delete($this->tablename);

        if($this->db->affected_rows()){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function login($column, $data)
	{
		$user = $data['email'];
        $password = $data['password'];
        $myquery = $this->db->select('*')
                            ->from($this->tablename)
                            ->where($column, $user)
                            ->limit(1);
        $rows = $myquery->get()->row();
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
