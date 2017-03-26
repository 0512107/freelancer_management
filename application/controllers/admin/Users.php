<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Users extends CI_Controller{
	public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_logged')) {
            redirect(base_url() . 'login');
        }
		
		if ($this->session->userdata('role') != "admin") {
			redirect(base_url() . 'dashboard');
		}
    }
	
	public function index() {
		$arr['page']='users';		
		$this->load->view('admin/viewUsers',$arr);
    }
	
	public function get_users() {
		$this->load->model('User');
		$searchValue = $this->input->post('search')['value'];
		$limit = $this->input->post('length');
		if (!empty($searchValue)) {
			$listUser = $this->User->search("*", array('full_name' => $searchValue, "is_deleted" => 0), "", $limit);
			$totalRecord = $this->User->getCountSearch(array('full_name' => $searchValue, "is_deleted" => 0));
			$result = array(
				"draw" => $this->input->post('draw'),
				"recordsTotal" => $totalRecord,
				"recordsFiltered" => $totalRecord,
				"data" => $listUser
			);
			echo json_encode($result);
			exit;
		}
		$start = intval($this->input->post('start'));		
		$listUser = $this->User->getList("*", array("is_deleted" => 0), "", $limit, $start);
		foreach($listUser as $key => $user) {
			$listUser[$key]['description'] = htmlspecialchars ($user['description']);
		}
		$totalRecord = $this->User->getCount(array("is_deleted" => 0));
		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $totalRecord,
			"recordsFiltered" => $totalRecord,
			"data" => $listUser
		);
		echo json_encode($result);
		exit;
	}
	
	public function insert() {
		if ($this->input->method() == "post") {
			$this->load->model('User');
			$email = trim($this->input->post('email'));
			$numRow = $this->User->getCount(array("email" => $email));
			if ($numRow > 0) {
				echo json_encode(array("result" => "error", "field" => "email" ,"message" => "<strong>Error</strong> The email has already been taken"));
				exit;
			} else {
				$firstName = trim($this->input->post('first_name'));
				$lastName = trim($this->input->post('last_name'));
				$fullName = $firstName . " " . $lastName;
				$phone = trim($this->input->post('phone'));
				$email = trim($this->input->post('email'));
				$description = trim($this->input->post('description'));
				$role = trim($this->input->post('role'));
				$bankName = trim($this->input->post('bank_name'));
				$bankNumber = trim($this->input->post('bank_number'));
				$address = trim($this->input->post('address'));
				$updated = time();
				$created = time();
				$defaultPassword = "512e7bc8ca075f8da2fd4b9a34f080e3"; //123456
				$data = array(
					"first_name" => $firstName,
					"last_name" => $lastName,
					"full_name" => $fullName,
					"phone" => $phone,
					"email" => $email,
					"description" => $description,
					"role" => $role,
					"bank_name" => $bankName,
					"bank_number" => $bankNumber,
					"password" => $defaultPassword,
					"address" => $address,
					"updated" => $updated,
					"created" => $created
				);
				if ($this->User->insert($data)) {
					echo json_encode(array("result" => "success", "message" => "The new customer has been saved!"));
					exit;
				} else {
					echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
					exit;
				}
			}
		} else {
			redirect(base_url() . '404');
		}
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
		} else {
			redirect(base_url() . '404');
		}
	}
	
	public function delete() {
		if ($this->input->method() == "post") {
			$this->load->model('User');
			$email = trim($this->input->post('email'));
			$id = trim($this->input->post('id'));
			$updated = time();
			
			$data = array(
				"is_deleted" => 1,
				"updated" => $updated				
			);
			if ($this->User->update($data, array("id" => $id))) {
				echo json_encode(array("result" => "success", "message" => "Deleted"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			redirect(base_url() . '404');
		}
	}
}