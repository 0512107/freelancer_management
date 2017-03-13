<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Customers extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_user_login')) {
            redirect(base_url() . 'login');
        }
    }
     
    public function index() {
		$arr['page']='customers';		
		$this->load->view('viewCustomer',$arr);
    }
	
	public function get_customers() {
		$this->load->model('ModelCustomers');
		$searchValue = $this->input->post('search')['value'];
		$limit = $this->input->post('length');
		if (!empty($searchValue)) {
			$listCustomer = $this->ModelCustomers->search("*", array('full_name' => $searchValue, "is_deleted" => 0), "", $limit);
			$totalRecord = $this->ModelCustomers->getCountSearch(array('full_name' => $searchValue, "is_deleted" => 0));
			$result = array(
				"draw" => $this->input->post('draw'),
				"recordsTotal" => $totalRecord,
				"recordsFiltered" => $totalRecord,
				"data" => $listCustomer
			);
			echo json_encode($result);
			exit;
		}
		$start = intval($this->input->post('start'));		
		$listCustomer = $this->ModelCustomers->getList("*", array("is_deleted" => 0), "", $limit, $start);
		foreach($listCustomer as $key => $customer) {
			$listCustomer[$key]['description'] = htmlspecialchars ($customer['description']);
		}
		$totalRecord = $this->ModelCustomers->getCount(array("is_deleted" => 0));
		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $totalRecord,
			"recordsFiltered" => $totalRecord,
			"data" => $listCustomer
		);
		echo json_encode($result);
		exit;
	}
	
	public function insert() {
		if ($this->input->method() == "post") {
			$this->load->model('ModelCustomers');
			$email = trim($this->input->post('email'));
			$numRow = $this->ModelCustomers->getCount(array("email" => $email));
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
				$updated = time();
				$created = time();
				$data = array(
					"first_name" => $firstName,
					"last_name" => $lastName,
					"full_name" => $fullName,
					"phone" => $phone,
					"email" => $email,
					"description" => $description,
					"updated" => $updated,
					"created" => $created
				);
				if ($this->ModelCustomers->insert($data)) {
					echo json_encode(array("result" => "success", "message" => "The new customer has been saved!"));
					exit;
				} else {
					echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
					exit;
				}
			}
		}
	}
	
	public function update() {
		if ($this->input->method() == "post") {
			$this->load->model('ModelCustomers');
			$firstName = trim($this->input->post('first_name'));
			$lastName = trim($this->input->post('last_name'));
			$fullName = $firstName . " " . $lastName;
			$phone = trim($this->input->post('phone'));
			$email = trim($this->input->post('email'));
			$description = trim($this->input->post('description'));
			$updated = time();
			
			$data = array(
				"first_name" => $firstName,
				"last_name" => $lastName,
				"full_name" => $fullName,
				"phone" => $phone,
				"email" => $email,
				"description" => $description,
				"updated" => $updated				
			);
			if ($this->ModelCustomers->update($data, array("email" => $email))) {
				echo json_encode(array("result" => "success", "message" => "Updated"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		}
	}
	
	public function delete() {
		if ($this->input->method() == "post") {
			$this->load->model('ModelCustomers');
			$email = trim($this->input->post('email'));
			$id = trim($this->input->post('id'));
			$updated = time();
			
			$data = array(
				"is_deleted" => 1,
				"updated" => $updated				
			);
			if ($this->ModelCustomers->update($data, array("id" => $id))) {
				echo json_encode(array("result" => "success", "message" => "Deleted"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		}
	}
}
?>