<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public $temp = 0;
    public function __construct()
    {
        parent::__construct();
        $this->db->db_select(DATABASE_NAME);
        $this->load->model('updatedmodel');
        $this->load->helper("security");
    }

    function json_output($statusHeader, $response)
    {
        $ci = &get_instance();
        $ci->output->set_content_type('application/json');
        $ci->output->set_status_header($statusHeader);
        $ci->output->set_output(json_encode($response));
    }

    function tooManyRequest()
    {
        return array('status' => 429, 'message' => 'Too many request' );
    }

    public function index()
    {

    }

}
