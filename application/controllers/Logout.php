<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Logout extends CI_Controller {
	public function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('is_admin_login');   
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('/', 'refresh');
    }
}