<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
		$data['csrf'] = array(
		    'name' => $this->security->get_csrf_token_name(),
		    'hash' => $this->security->get_csrf_hash()
		);
	}
	
	// Useful snippet
	// recaptcha
	protected function recaptchaverify($recaptcha)
    	{
        $recaptchaResponse = trim($recaptcha);
        $userIp = $this->input->ip_address();
        $secret = $this->config->item('google_secret');
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $status = json_decode($output, true);
        return $status;
    	}
	
	function sendCustomMail($email, $text, $subject)
    	{
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'xxx',
            'smtp_port' => 587,
            'smtp_user' => 'xxx',
            'smtp_pass' => 'xxx',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from('no-reply@hackerji.com', 'Team Hackerji');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($text);
        $this->email->send();
    }
	function upload(){
	                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path'] = 'assets/uploads/company/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2000;
                    $config['file_name'] = md5($_FILES['image']['name'] . date("dmYHis"));

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $uploadFile = $this->upload->do_upload('image');
                    if ($uploadFile) {
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    } else {
                        $this->session->set_flashdata('message', array('warning', $this->upload->display_errors()));
                        redirect('company/addProgram', 'refresh');
                    }
                } 
	}
}
