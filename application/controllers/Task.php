<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Task extends CI_Controller{
	
    public function __construct() {
        parent::__construct();
		if (!$this->session->userdata('is_logged')) {
            redirect(base_url() . 'login');
        }
    }
	
	public function insert() {
		if ($this->input->method() == "post") {
			$name = trim($this->input->post("name"));
			$projectId = trim($this->input->post("project_id"));
			$projectName = trim($this->input->post("project_name"));
			$userCreateId = trim($this->input->post("user_create_id"));
			$userCreateName = trim($this->input->post("user_create_name"));
			$estimateHours = trim($this->input->post("estimate_hours"));
			$assignee = trim($this->input->post('assignee'));
			$description = trim($this->input->post("description"));
			
			$assigneeId  = 0;
			$assigneeName = "";
			if (!empty($assignee)) {
				$temp = explode("-", $assignee);
				$assigneeId = $temp[0];
				$assigneeName = $temp[1];
			}
			$updated = time();
			$created = time();
			
			$data = array(
				"name" => $name,
				"project_id" => $projectId,
				"project_name" => $projectName,
				"user_assignee_id" => $assigneeId,
				"user_assignee_name" => $assigneeName,
				"user_create_id" => $userCreateId,
				"user_create_name" => $userCreateName,
				"estimate_hours" => $estimateHours,
				"complete_hours" => 0,
				"is_completed" => 0,
				"is_payment" => 0,
				"files_changed" => "",
				"description" => $description,
				"updated" => $updated,
				"created" => $created
			);
			
			$this->load->model("ModelTasks");
			if ($this->ModelTasks->insert($data)) {
				echo json_encode(array("result" => "success", "message" => "The new task has been saved!"));
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