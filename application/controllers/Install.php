<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	public function index()
	{
		$this->load->database();
		$this->load->dbforge();
		
		$query = $this->db->query('show tables');
		$result=$query->result_array();
		foreach ($result as $table){
			$this->dbforge->drop_table($table['Tables_in_dbname'],TRUE);
        }
            $fields = array(
			'email' => array(
					'type' => 'VARCHAR',
					'constraint' => '100',
                    'unique' => TRUE,
            ),
            
			'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
        	),
        
			'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                
        	),
			'profile' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
				'default' => NULL,
        	),
			'contact' => array(
					'type' =>'VARCHAR',
					'constraint' => '100',
            ),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'User',
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => 'Active',
            ),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => '300',
				'default' => 'Active',
            ),
			'paypal' => array(
				'type' => 'VARCHAR',
				'constraint' => '300',
				'default' => 'Active',
            ),
			'tokens' => array(
				'type' => 'TEXT',
                'null' => TRUE,
			),
			'devices' => array(
				'type' => 'TEXT',
                'null' => TRUE,
			),
			'points' => array(
				'type' =>'INT',
				'constraint' => '100',
				'default' => '0',
            ),
			'created_time datetime default current_timestamp' ,
			'modified_time datetime default current_timestamp on update current_timestamp' ,
		);
		$this->dbforge->add_field('id');
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('users', TRUE);

		$admin['email'] = 'testyokesh@gmail.com';
		$admin['name'] = 'yokesh';
		$admin['password'] = "Nutz-yoke".crypt('123','sh');
		$admin['contact'] = '9876543210';
		$admin['status'] = 'Active';
		$admin['devices'] = '';
		$this->db->insert('users', $admin);
  }
} 
