<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Dashboard extends CI_Controller{
    public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_logged')) {
            redirect(base_url() . 'login');
        }
    }
     
    public function index() {
		$arr['page']='dash';
		//$arr['subPage'] = '';
		$this->load->view('viewDashboard',$arr);
    }
}
?>