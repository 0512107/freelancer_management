<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Project extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_logged')) {
            redirect(base_url() . 'login');
        }
    }
	
	public function index($id = "", $taskId = "") {		
		if (empty($id)) {
			$this->load->view("view404");
		}
		
		$this->load->model("ModelProjects");
		$likeQuery = '"id":"' . $this->session->userdata("id") . '"';
		$project = $this->ModelProjects->search("*", array("id" => $id), array("members" => $likeQuery));
		if (count($project) == 0) {
			$this->load->view("view404");
		} else {
			$this->load->model("ModelCustomers");
			$this->load->model("User");
			$this->load->library('mobiledetect');
			$this->load->model("ModelTasks");
			$arr['listCustomer'] = $this->ModelCustomers->getList("id, full_name", array("is_deleted" => 0));
			$arr['tasksNotComplete'] = $this->ModelTasks->getList("*", array("project_id" => $project[0]["id"], "is_completed" => 0));
			$arr['users'] = $this->User->getList("id, full_name", array("is_deleted" => 0));
			$arr['project'] = $project[0];
			$arr['page']='projects';
			$arr['subPage']='project_' . $project[0]["id"];
			$arr['taskId'] = $taskId;
			$this->load->view("viewProject", $arr);
		}
    }
	
	public function updateEstimateHours() {
		if ($this->input->method("post")) {
			$idTask = trim($this->input->post("task_id"));
			if (empty($idTask)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			$estimateHours = trim($this->input->post("estimate_hours"));
			$data = array(
				"estimate_hours" => $estimateHours,
				"updated" => time()
			);
			$this->load->model("ModelTasks");
			if ($this->ModelTasks->update($data, array("id" => $idTask))) {
				echo json_encode(array("result" => "success", "message" => "Updated"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
			exit;
		}
	}
	
	public function updateAssignee() {
		if ($this->input->method("post")) {
			$idTask = trim($this->input->post("taskId"));
			$userAssignee = trim($this->input->post("userAssignee"));
			if (empty($idTask)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			
			$userAssigneeId = 0;
			$userAssigneeName = "";
			if (!empty($userAssignee)) {
				$temp = explode("-", $userAssignee);
				$userAssigneeId = $temp[0];
				$userAssigneeName = $temp[1];
			}
			
			$data = array(
				"user_assignee_id" => $userAssigneeId,
				"user_assignee_name" => $userAssigneeName,
				"updated" => time()
			);
			$this->load->model("ModelTasks");
			if ($this->ModelTasks->update($data, array("id" => $idTask))) {
				echo json_encode(array("result" => "success", "message" => "Updated"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
			exit;
		}
	}
	
	public function updateCompleted() {
		if ($this->input->method("post")) {
			$idTask = trim($this->input->post("taskId"));
			$userAssignee = trim($this->input->post("userAssignee"));
			if (empty($idTask)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			$this->load->model("ModelTasks");
			$taskTimeCreated = $this->ModelTasks->getList("created", array("id" => $idTask))[0];
			$completeHours = time() - intval($taskTimeCreated["created"]);
			$completeHours = intval(floor($completeHours) / 3600);
			$data = array(
				"is_completed" => 1,
				"complete_hours" => $completeHours,
				"updated" => time()
			);
			
			
			if ($this->ModelTasks->update($data, array("id" => $idTask))) {
				echo json_encode(array("result" => "success", "message" => "Updated"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
			exit;
		}
	}
	
	public function deleteTask() {
		if ($this->input->method("post")) {
			$idTask = trim($this->input->post("taskId"));
			if (empty($idTask)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			$this->load->model("ModelTasks");
			if ($this->ModelTasks->delete(array("id" => $idTask))) {
				echo json_encode(array("result" => "success", "message" => "Deleted"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
			exit;
		}
	}
	
	public function updateTitleTask() {
		if ($this->input->method("post")) {
			$idTask = trim($this->input->post("taskId"));
			if (empty($idTask)) {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
			$nameTask = trim($this->input->post("nameTask"));
			$data = array("name" => $nameTask);
			$this->load->model("ModelTasks");
			if ($this->ModelTasks->update($data, array("id" => $idTask))) {
				echo json_encode(array("result" => "success", "message" => "Deleted"));
				exit;
			} else {
				echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "field" => "", "message" => "<strong>Error:</strong> Whoops! There was an error "));
		}
	}
}