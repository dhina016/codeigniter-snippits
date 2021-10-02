<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Updatedmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db->db_select(DATABASE_NAME);
    }

    public $tablename = "";
    public $jointable = "";



    public function getData($data = array())
    {
        if (!$this->checkThrottle()) {
            return 'throttled';
        }

        $condition = '';
        $selectedValue = '*';
        $orderby = '';
        $groupby = '';
        $like = array();
        $nlike = array();
        $join = array();
        $limit = 0;
        $offset = 0;
        if (array_key_exists('where', $data)) {
            $condition = $data['where'];
        }
        if (array_key_exists('select', $data)) {
            $selectedValue = $data['select'];
        }
        if (array_key_exists('join', $data)) {
            $join = $data['join'];
        }
        if (array_key_exists('orderby', $data)) {
            $orderby = $data['orderby'];
        }
        if (array_key_exists('like', $data)) {
            $like = $data['like'];
        }
        if (array_key_exists('nlike', $data)) {
            $nlike = $data['nlike'];
        }
        if (array_key_exists('groupby', $data)) {
            $groupby = $data['groupby'];
        }
        if (array_key_exists('limit', $data)) {
            $limit = $data['limit'];
        }
        if (array_key_exists('offset', $data)) {
            $offset = $data['offset'];
        }
        $query = $this->db->select($selectedValue);
        $this->db->from($this->tablename);
        foreach ($join as $key => $value) {
            $this->db->join($key, $value);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }
        foreach ($like as $key => $value) {
            $this->db->like($key, $value);
        }
        foreach ($nlike as $key => $value) {
            $this->db->not_like($key, $value);
        }
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        if ($orderby != '') {
            $this->db->order_by($orderby);
        }
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }
        return $query->get();
    }


    public function insertData($data)
    {
        if (!$this->checkThrottle()) {
            return 'throttled';
        }
        if(!$this->addThrottle()){
            return 'something wrong';
        }
        $this->db->insert($this->tablename, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function insertBatchData($data)
    {
        if (!$this->checkThrottle()) {
            return 'throttled';
        }
        if(!$this->addThrottle()){
            return 'something wrong';
        }
        $this->db->insert_batch($this->tablename, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function updateData($condition, $data)
    {
        if (!$this->checkThrottle()) {
            return 'throttled';
        }
        $this->db->where($condition);
        $this->db->update($this->tablename, $data);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteData($condition)
    {
        $this->db->where($condition);
        $this->db->delete($this->tablename);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function login($column, $data)
    {
        if (!$this->checkThrottle()) {
            return 'throttled';
        }
        if(!$this->addThrottle()){
            return 'something wrong';
        }
        $user = $data['username'];
        $password = $data['password'];
        $myquery = $this->db->select('*')
            ->from($this->tablename)
            ->where($column, $user);
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

    public function checkThrottle()
    {
        $ip = $this->input->ip_address();
        $query = $this->db->query('SELECT * FROM throttle where ipaddress = "'.$ip.'" and fname = "'.$this->tablename.'" and  create_at BETWEEN date_sub(now(), interval 1 hour) AND now();');
        if($query->num_rows() > 10){
            return false;
        } 
        return true;
    }


    public function addThrottle()
    {

        $ip = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        $data = array(
            'ipaddress' => $ip,
            'fname' => $this->tablename,
            'user_agent' => $user_agent,
        );
        $this->db->insert('throttle', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
}
