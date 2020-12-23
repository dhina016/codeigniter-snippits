<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

        $this->db->db_select(DATABASE_NAME);
        $this->load->model('basemodel');
	} 

	public function index()
	{
        
    }
}
