<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Projects extends CI_Controller{
	
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
		$arr['page']='projects';
		$arr['subPage']='projects';
		$this->load->model("ModelCustomers");
		$this->load->model("User");
		$arr['listCustomer'] = $this->ModelCustomers->getList("id, full_name", array("is_deleted" => 0));
		$arr['listUser'] = $this->User->getList("id, full_name", array("is_deleted" => 0));
		$this->load->view('admin/viewProjects',$arr);
    }
	
	public function get_projects() {
		$this->load->model('ModelProjects');
		$searchValue = $this->input->post('search')['value'];
		$limit = $this->input->post('length');
		if (!empty($searchValue)) {
			$listProject = $this->ModelProjects->search("*", array(), array('name' => $searchValue), "", $limit);
			$totalRecord = $this->ModelProjects->getCountSearch(array(), array('name' => $searchValue));
			$result = array(
				"draw" => $this->input->post('draw'),
				"recordsTotal" => $totalRecord,
				"recordsFiltered" => $totalRecord,
				"data" => $listProject
			);
			echo json_encode($result);
			exit;
		}
		$start = intval($this->input->post('start'));		
		$listProject = $this->ModelProjects->getList("*", array(), "", $limit, $start);
		foreach($listProject as $key => $project) {
			$listProject[$key]['description'] = htmlspecialchars ($project['description']);
		}
		$totalRecord = $this->ModelProjects->getCount();
		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $totalRecord,
			"recordsFiltered" => $totalRecord,
			"data" => $listProject
		);
		echo json_encode($result);
		exit;
	}
	
	public function insert() {
		if ($this->input->method() == "post") {
			$this->load->model('ModelProjects');
			$code = trim($this->input->post('code'));
			$numRow = $this->ModelProjects->getCount(array("code" => $code));
			if ($numRow > 0) {
				echo json_encode(array("result" => "error", "field" => "code" ,"message" => "<strong>Error</strong> The code has already been taken"));
				exit;
			} else {
				$name = trim($this->input->post('name'));
				$projectOwnerId = trim($this->input->post('project_owner_id'));
				$projectOwnerName = trim($this->input->post('project_owner_name'));
				$description = trim($this->input->post('description'));
				$customer = trim($this->input->post('customer'));
				$customerId = "";
				$customerName = "";
				if (!empty($customer)) {
					$temp = explode("-", $customer);
					$customerId = $temp[0];
					$customerName = $temp[1];
				}
				$membersInput = $this->input->post("members");
				$members = array();
				foreach($membersInput as $key => $member) {
					$temp = explode("-", $member);
					$idUser = $temp[0];
					$nameUser = $temp[1];
					array_push($members, array("id" => $idUser, "name" => $nameUser));
				}
				
				$updated = time();
				$created = time();
				$data = array(
					"code" => $code,
					"name" => $name,
					"project_owner_id" => $projectOwnerId,
					"project_owner_name" => $projectOwnerName,
					"customer_id" => $customerId,
					"customer_name" => $customerName,
					"description" => $description,
					"members" => json_encode($members, JSON_UNESCAPED_UNICODE),
					"updated" => $updated,
					"created" => $created
				);
				if ($this->ModelProjects->insert($data)) {
					echo json_encode(array("result" => "success", "message" => "The new project has been saved!"));
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
			$this->load->model('ModelProjects');
			$idProject = trim($this->input->post('id'));
			if (empty($idProject)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			
			$code = trim($this->input->post('code'));
			$name = trim($this->input->post('name'));
			$description = trim($this->input->post('description'));
			$projectOwnerId = trim($this->input->post('project_owner_id'));
			$projectOwnerName = trim($this->input->post('project_owner_name'));
			$updated = time();
			$customer = trim($this->input->post('customer'));
			$customerId = "";
			$customerName = "";
			if (!empty($customer)) {
				$temp = explode("-", $customer);
				$customerId = $temp[0];
				$customerName = $temp[1];
			}
			
			$isCompleted = trim($this->input->post('is_completed'));
			if ($isCompleted == "on") {
				$isCompleted = 1;
			} else {
				$isCompleted = 0;
			}
			
			$membersInput = $this->input->post("members");
			$members = array();
			if(!empty($membersInput)) {
				foreach($membersInput as $key => $member) {
					$temp = explode("-", $member);
					$idUser = $temp[0];
					$nameUser = $temp[1];
					array_push($members, array("id" => $idUser, "name" => $nameUser));
				}
			}
			$data = array(
				"code" => $code,
				"name" => $name,
				"project_owner_id" => $projectOwnerId,
				"project_owner_name" => $projectOwnerName,
				"customer_id" => $customerId,
				"customer_name" => $customerName,
				"description" => $description,
				"members" => json_encode($members, JSON_UNESCAPED_UNICODE),
				"is_completed" => $isCompleted,
				"updated" => $updated
			);
			
			if ($this->ModelProjects->update($data, array("id" => $idProject))) {
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
			$code = trim($this->input->post('code'));
			$id = trim($this->input->post('id'));
			if (empty($id)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			$this->load->model('ModelProjects');
			if ($this->ModelProjects->delete(array("id" => $id))) {
				echo json_encode(array("result" => "success", "message" => "Deleted"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		}
	}
}