<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Personal_infor extends CI_Controller{
	public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_logged')) {
            redirect(base_url() . 'login');
        }
	}
	
	public function index() {
		$this->load->model("User");
		$arr['page']= 'personal-infor';
		$arr['infor'] =  $this->User->getList("*", array("id" => $this->session->userdata("id")))[0];
		
		$this->load->view('user/viewPersonalInfor',$arr);
    }
	
	public function update() {
		if ($this->input->method() == "post") {
			$firstName = trim($this->input->post('first_name'));
			$lastName = trim($this->input->post('last_name'));
			$fullName = $firstName . " " . $lastName;
			$phone = trim($this->input->post('phone'));
			$email = trim($this->input->post('email'));
			$description = trim($this->input->post('description'));
			
			$bankName = trim($this->input->post('bank_name'));
			$bankNumber = trim($this->input->post('bank_number'));
			$address = trim($this->input->post('address'));
			$updated = time();
			$created = time();
			$data = array(
				"first_name" => $firstName,
				"last_name" => $lastName,
				"full_name" => $fullName,
				"phone" => $phone,
				"email" => $email,
				"description" => $description,
				"bank_name" => $bankName,
				"bank_number" => $bankNumber,
				"address" => $address,
				"updated" => $updated
			);
			
			if ($this->session->userdata("role") == "admin") {
				$role = trim($this->input->post('role'));
				$data["role"] = $role;
			}
			$this->load->model('User');
			if ($this->User->update($data, array("email" => $email))) {
				echo json_encode(array("result" => "success", "message" => "Updated"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		}
	}
}	
?>