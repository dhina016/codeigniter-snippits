<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Install extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->db->db_select(DATABASE_NAME);
	}

	
	public function index()
	{

		$this->load->database();
		$this->load->dbforge();
		// clear table 
		$query = $this->db->query('show tables');
		$result = $query->result_array();
		foreach ($result as $table) {
			$this->dbforge->drop_table($table['Tables_in_testing'], TRUE);
		}

		// throttle 
		$fields = array(
			'ipaddress' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'fname' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',

			),
			'user_agent' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',

			),
			'logged_id' => array(
				'type' => 'INT',
                'constraint' => 9,
				'null' => TRUE
			),
			'create_at datetime default current_timestamp',
			'modified_at datetime default current_timestamp on update current_timestamp',
		);
		$this->dbforge->add_field('id');
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('throttle', TRUE);

	}
}
