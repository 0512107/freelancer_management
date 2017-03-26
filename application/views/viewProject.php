<?php 
	$arr['pageTitle'] = "List User";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "datatables/3/dataTables.bootstrap.css",
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css",
		HTTP_LIB_PATH . "switch/css/bootstrap3/bootstrap-switch.min.css",
		HTTP_LIB_PATH . "chosen/chosen.min.css",
		HTTP_LIB_PATH . "bootstrap/css/bootstrap-datetimepicker.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<div style="float:left;">
			<h3><i class="fa fa-user-circle-o"></i>&nbsp; <?php echo $project['name'] ?><div class="title-arrow-down"><i class="fa fa-angle-down dialog-edit"></i></div></h3>
		</div>
		<div style="float:right;">
			<div class="btn-group">
				<a data-placement="bottom" data-original-title="Show / Hide Menu" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
				  <i class="fa fa-bars"></i>
				</a> 
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</header>

<div class="outer">
	<div class="inner lter" style="border: none; background-color: #e4e4e4; padding: 20px;">
		<?php if ($this->mobiledetect->isMobile()) { ?>
		<div class="row master">
			master
			
		</div>
		<div class="row detail">
		detail
		</div>
		<?php } else { ?>
			<div class="content-left">
				<div>
					<div class="container-button-add-task">
						<div class="button-add-task" style="">
							<div class="text-button-add-task"> Add Task	</div>
						</div>
					</div>
					
				</div>
				
				<table style="width: 100%;" class="list-task">
					<?php foreach ($tasksNotComplete as $key => $task) { 
						unset($task["description"]);
						unset($task["files_changed"]);
					?>
						<tr class="task-item <?php echo (intval($taskId) > 0 && $task["id"] == $taskId) ? "active" : ''?>" valign="middle" data-task='<?php echo json_encode($task, JSON_UNESCAPED_UNICODE ); ?>'  data-user-logged='<?php $userLogged = array("id" => $this->session->userdata("id"), "name" => $this->session->userdata("full_name"));  echo json_encode( $userLogged , JSON_UNESCAPED_UNICODE); ?>'>
							<td style="width:10px;"></td>
							<td style="width: 31px; vertical-align: middle;">
								<div class="mark-complete-border">
									<div class="mark-complete-container">
										<span style="height: 12px; width: 12px; display: inline-block;">
											<svg class="svgIcon " viewBox="0 0 32 32" title="checkmark"><polygon class="checked" points="27.672,4.786 10.901,21.557 4.328,14.984 1.5,17.812 10.901,27.214 30.5,7.615 "></polygon></svg>
										</span>
									</div>
								</div>
							</td>
							
							<td style="cursor: pointer;">
								<div style="height: 35px; line-height: 35px; color: #1B2432;" class="task-name" id-task="<?php echo $task["id"]; ?>">
									<?php echo $task["name"]; ?>
								</div>
							</td>
							<td style="text-align:right; color: #000; width: 35px;">
								<?php if ($task["user_assignee_id"] == 0) { ?>
								<div class="border-icon-not-assignee" data-placement="bottom" data-original-title="Assign this task" data-toggle="tooltip">
									<div class="icon-not-assignee-container">
										<svg class="icon-not-assignee" title="UserIcon" viewBox="0 0 32 32"><path d="M20.534,16.765C23.203,15.204,25,12.315,25,9c0-4.971-4.029-9-9-9S7,4.029,7,9c0,3.315,1.797,6.204,4.466,7.765C5.962,18.651,2,23.857,2,30c0,0.681,0.065,1.345,0.159,2h27.682C29.935,31.345,30,30.681,30,30C30,23.857,26.038,18.651,20.534,16.765z M9,9c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S9,12.86,9,9z M4,30c0-6.617,5.383-12,12-12s12,5.383,12,12H4z"></path></svg>
									</div>
								</div>
								<?php } else { 
									$shortName = "";
									if (!empty($task["user_assignee_name"])) {
										$shortNameArray = explode(" ", $task["user_assignee_name"]);
										if(count($shortNameArray) > 1) {
											$shortName = strtoupper(mb_substr($shortNameArray[0],0,1) . mb_substr($shortNameArray[1],0,1));
										} else {
											$shortName = strtoupper(mb_substr($task["user_assignee_name"],0,1));
										}
									}
									
									if (empty($shortName)) { 
								?>
									<div class="icon-assigned-container">
										<svg class="icon-not-assignee" title="UserIcon" viewBox="0 0 32 32"><path d="M20.534,16.765C23.203,15.204,25,12.315,25,9c0-4.971-4.029-9-9-9S7,4.029,7,9c0,3.315,1.797,6.204,4.466,7.765C5.962,18.651,2,23.857,2,30c0,0.681,0.065,1.345,0.159,2h27.682C29.935,31.345,30,30.681,30,30C30,23.857,26.038,18.651,20.534,16.765z M9,9c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S9,12.86,9,9z M4,30c0-6.617,5.383-12,12-12s12,5.383,12,12H4z"></path></svg>
									</div>
								<?php } else { ?>
									<div class="icon-assigned-container"><?php echo $shortName; ?></div>
								<?php } } ?>
							</td>
							<td style="width:10px;">
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
			
			<div class="content-right" data-task="">
				<div class="top-header">
					<div class="content-task-left" style="color: #ccc; margin-top: 15px; float: left;">
						<div class="task-assignee-right" data-placement="bottom" data-original-title="Assign this task" data-toggle="tooltip">
							<div class="detail-task-border-assignee" style="display: none;">
								<div class="detail-task-border-assignee-button">
									<svg title="UserIcon" viewBox="0 0 32 32"><path d="M20.534,16.765C23.203,15.204,25,12.315,25,9c0-4.971-4.029-9-9-9S7,4.029,7,9c0,3.315,1.797,6.204,4.466,7.765C5.962,18.651,2,23.857,2,30c0,0.681,0.065,1.345,0.159,2h27.682C29.935,31.345,30,30.681,30,30C30,23.857,26.038,18.651,20.534,16.765z M9,9c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S9,12.86,9,9z M4,30c0-6.617,5.383-12,12-12s12,5.383,12,12H4z"></path></svg>
								</div>
								<span>&nbsp; Unassigned </span>
							</div>
							
							<div class="detail-task-border-assigned" style="display: none;">
								<div class="detail-task-border-assigned-button">
									DD
								</div>
								<span class="name-assignee-right">&nbsp; Đại Dũng </span>
								
								<div class="remove-assignee-button">
									<svg style="width:10px; height:10px;"class="Icon XIcon RemoveButton-xIcon" title="XIcon" viewBox="0 0 32 32"><polygon points="24.485,27.314 27.314,24.485 18.828,16 27.314,7.515 24.485,4.686 16,13.172 7.515,4.686 4.686,7.515 13.172,16 4.686,24.485 7.515,27.314 16,18.828 "></polygon></svg>
								</div>
							</div>
						</div>
						
						<div class="due-date-right" data-placement="bottom" data-original-title="Estimate Hours" data-toggle="tooltip">
							<div class="not-set-due-date-border" style="display: none;">
								<div class="not-set-due-date-container">
									<div class="not-set-due-date-icon">
										<svg class="Icon CalendarIcon" title="CalendarIcon" viewBox="0 0 32 32"><rect x="16" y="16" width="2" height="2"></rect><rect x="20" y="16" width="2" height="2"></rect><rect x="20" y="20" width="2" height="2"></rect><rect x="16" y="20" width="2" height="2"></rect><rect x="8" y="20" width="2" height="2"></rect><rect x="8" y="24" width="2" height="2"></rect><rect x="16" y="24" width="2" height="2"></rect><rect x="12" y="16" width="2" height="2"></rect><rect x="12" y="20" width="2" height="2"></rect><rect x="12" y="24" width="2" height="2"></rect><path d="M22,2V0h-2v2h-8V0h-2v2H2v30h28V2H22z M28,30H4V12h24V30z M28,10H4V4h6v2h2V4h8v2h2V4h6V10z"></path></svg>
									</div>
									
									<div class="not-set-value-due-date">Due date</div>
								</div>
							</div>
							
							<div class="set-due-date-border" style="display: none;">
								<div class="set-due-date-container">
									<div class="set-due-date-icon">
										<svg class="Icon CalendarIcon" title="CalendarIcon" viewBox="0 0 32 32"><rect x="16" y="16" width="2" height="2"></rect><rect x="20" y="16" width="2" height="2"></rect><rect x="20" y="20" width="2" height="2"></rect><rect x="16" y="20" width="2" height="2"></rect><rect x="8" y="20" width="2" height="2"></rect><rect x="8" y="24" width="2" height="2"></rect><rect x="16" y="24" width="2" height="2"></rect><rect x="12" y="16" width="2" height="2"></rect><rect x="12" y="20" width="2" height="2"></rect><rect x="12" y="24" width="2" height="2"></rect><path d="M22,2V0h-2v2h-8V0h-2v2H2v30h28V2H22z M28,30H4V12h24V30z M28,10H4V4h6v2h2V4h8v2h2V4h6V10z"></path></svg>
									</div>
									
									<div class="set-value-due-date">May 12, 2017 9:00am</div>
									
									<div class="remove-due-date">
										<svg style="width:10px; height:10px;"class="Icon XIcon RemoveButton-xIcon" title="XIcon" viewBox="0 0 32 32"><polygon points="24.485,27.314 27.314,24.485 18.828,16 27.314,7.515 24.485,4.686 16,13.172 7.515,4.686 4.686,7.515 13.172,16 4.686,24.485 7.515,27.314 16,18.828 "></polygon></svg>
									</div>
								</div>
							</div>
						</div>
						
						<div class="edit-task-right">
							<div class="edit-task-border">
								<div class="edit-task-container">
									<div class="edit-task-icon">
										<svg class="Icon MoreIcon" title="MoreIcon" viewBox="0 0 32 32"><circle cx="3" cy="16" r="3"></circle><circle cx="16" cy="16" r="3"></circle><circle cx="29" cy="16" r="3"></circle></svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="button-close-content-right">
						<svg class="icon XIcon CloseButton-xIcon" title="XIcon" viewBox="0 0 32 32"><polygon points="24.485,27.314 27.314,24.485 18.828,16 27.314,7.515 24.485,4.686 16,13.172 7.515,4.686 4.686,7.515 13.172,16 4.686,24.485 7.515,27.314 16,18.828 "></polygon></svg>
					</div>
				</div>
				
				<div style="clear:both;" class="title-task">
					<div class="content-title-task">
						<div class="mark-complete-border-right">
							<div class="mark-complete-container-right">
								<span style="height: 16px; width: 16px; display: inline-block;">
									<svg class="svgIcon " viewBox="0 0 32 32" title="checkmark"><polygon class="checked" points="27.672,4.786 10.901,21.557 4.328,14.984 1.5,17.812 10.901,27.214 30.5,7.615 "></polygon></svg>
								</span>
							</div>
						</div>
						
						<div class="name-task">
							<textarea class="value-name-task" wrap="soft" rows="1"></textarea>
						</div>
					</div>
				</div>
				
				<div style="clear:both;">
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<div class="edit-due-date-box box" data-task="" data-user-logged='<?php $userLogged = array("id" => $this->session->userdata("id"), "name" => $this->session->userdata("full_name"));  echo json_encode( $userLogged , JSON_UNESCAPED_UNICODE); ?>'>
	<form id="update-estimate-hours-form" action="<?php echo base_url() ?>project/updateEstimateHours" onclick="$('#update-estimate-hours-form').validationEngine('hide')">
		<div class="alert alert-danger" id="error-update-estimate-hours" style="display:none;"></div>
		<div class="alert alert-success" id="success-update-estimate-hours" style="display:none;"></div>
		<div class="form-group">
			<label for="name">Estimate Hours:</label>
			<input type="number" class="form-control validate[required]" id="estimate_hours" placeholder="Enter Estimate Hours" name="estimate_hours">
			<input type="hidden" value="" name="task_id" id="task_id">
		</div>
		<button id="bt-update-estimate-hours" type="submit" class="btn btn-metis-6 btn-xs">Update</button>
	</form>
</div>

<div class="edit-right-box-assignee box" data-task="" data-user-logged='<?php $userLogged = array("id" => $this->session->userdata("id"), "name" => $this->session->userdata("full_name"));  echo json_encode( $userLogged , JSON_UNESCAPED_UNICODE); ?>'>
	<select class="select-user-assignee-right" style="overflow: hidden; width:200px; padding: 5px;" data-placeholder="Assignee ...">
		<option val=""></option>
		<?php foreach($users as $key => $user) { ?>
			<option value="<?php echo $user["id"] . "-" . $user['full_name']; ?>"> <?php echo $user["full_name"]; ?> </option>
		<?php } ?>
	</select>
</div>

<div class="edit-box-task box" style="display: none;">
	<div class="dropdown-box">
		<a id="delete-task-menu" class="menu-item">Delete Task</a>
	</div>   
</div>

<div class="edit-box-project box" style="display: none;">
	<div class="dropdown-box">
		<a id="update-project-menu" class="edit-project-menu menu-item">Edit Project</a>
		<a id="delete-project-menu" class="menu-item">Delete Project</a>
	</div>   
</div>

<div class="edit-box-assignee box" data-task="" data-user-logged='<?php $userLogged = array("id" => $this->session->userdata("id"), "name" => $this->session->userdata("full_name"));  echo json_encode( $userLogged , JSON_UNESCAPED_UNICODE); ?>'>
	<p style="margin: 0px; font-size: 12px;">ASSIGNEE</p>
	<div style="margin-bottom: 10px;">
		<select class="user-assignee-list" style="overflow: hidden; width:170px; padding: 5px;" data-placeholder="Assignee ...">
			<option val=""></option>
			<?php foreach($users as $key => $user) { ?>
				<option value="<?php echo $user["id"] . "-" . $user['full_name']; ?>"> <?php echo $user["full_name"]; ?> </option>
			<?php } ?>
		</select>
		<span style="margin-left: 10px;">OR</span>
		<div class="button-assignee-to-me-container">
			<div class="button-assignee-to-me">
				<a href="#">Assignee to Me</a>
			</div>
		</div>
		
	</div>
</div>

<div id="modal-update-project" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Update Project</h4>
			</div>
			<form id="update-project-form" action="<?php echo base_url() ?>admin/projects/update" onclick="$('#update-project-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-update-project" style="display:none;"></div>
					<div class="alert alert-success" id="success-update-project" style="display:none;"></div>
					<input type="hidden" value="" id="id-project-update-form" name="id"> 
					<div class="col-lg-6">
						<div class="form-group">
							<label for="code">Code:</label>
							<input readonly type="text" class="validate[required] form-control" id="code_update" placeholder="Enter Code Project" name="code">
						</div>
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="text" class="validate[required] form-control" id="name_update" placeholder="Enter Name Project" name="name">
							
						</div>
						
						<div class="form-group">
							<div class="col-lg-6" style="padding-left: 0px;">
								<label for="name">Is Completed:</label>
							</div>
							<div class="col-lg-6" style="padding-left: 0px;">
								<input type="checkbox" id="is_completed_update" name="is_completed" data-size="mini" data-on-text="TRUE" data-off-text="FALSE">
							</div>
						</div>
						
					</div>
					
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">Project Owner:</label>
							<input readonly value="" type="text" class="form-control" id="project_owner_name_update" name="project_owner_name">
							<input readonly value="" type="hidden" class="form-control" id="project_owner_id_update" name="project_owner_id">
						</div>
						<div class="form-group">
							<label for="customer">Customer:</label>
							<div style="width: 100%;">
								<select name="customer" id="customer_update" class="form-control" data-placeholder="Choose a Customer...">
									<option value=""></option>
									<?php 
										foreach($listCustomer as $key => $customer) {
									?>
										<option value="<?php echo $customer["id"] . "-" . $customer["full_name"]; ?>"><?php echo $customer["full_name"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="description" class="control-label">Description:</label>
							<div>
								<textarea maxlength="140" class="form-control" id="description_update" placeholder="Enter description" name="description"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button id="bt-update-project-dialog" type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-delete-project" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Delete Project</h4>
			</div>
			<form id="delete-project-form" action="<?php echo base_url() ?>admin/projects/delete" onclick="$('#delete-project-form').validationEngine('hide')">
				<input type="hidden" value="" class="form-control" id="code_delete_form" name="code">
				<input type="hidden" value="" class="form-control" id="id_delete_form" name="id">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-delete-project" style="display:none;"></div>
					<div class="alert alert-success" id="success-delete-project" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Delete the project : <b><i id="name_project"></i></b> ?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button id="bt-delete-project-dialog" type="submit" class="btn btn-primary">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-add-new-task" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Add New Task	</h4>
			</div>
			<form id="add-task-form" action="<?php echo base_url() ?>task/insert" onclick="$('#add-task-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-add-task" style="display:none;"></div>
					<div class="alert alert-success" id="success-add-task" style="display:none;"></div>
					<input type="hidden" value="<?php echo $project["id"]; ?>" name="project_id">
					<input type="hidden" value="<?php echo $project["name"]; ?>" name="project_name">
					<input type="hidden" value="<?php echo $this->session->userdata("id"); ?>" name="user_create_id">
					<input type="hidden" value="<?php echo $this->session->userdata("full_name"); ?>" name="user_create_name">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="code">Name:</label>
							<input type="text" class="validate[required] form-control" id="name_insert" placeholder="Enter Name Task" name="name">
						</div>
						
						<div class="form-group">
							<label for="name">Estimate Hours:</label>
							<div class="input-group">
								<span class="input-group-addon" id="addon_estimate_hours">Hours</span>
								<input type="text" class="validate[required,custom[onlyNumberSp]] form-control" id="estimate_hours_insert" placeholder="Enter Estimate Hours" name="estimate_hours" aria-describedby="addon_estimate_hours">
							</div>
							
						</div>
						
						<div class="form-group">
							<label for="customer">Assignee:</label>
							<div style="width: 100%; height: 50px;">
								<select name="assignee" id="assignee_insert" class="form-control" data-placeholder="Choose a Assignee...">
									<option value=""></option>
									<?php 
										foreach($users as $key => $user) {
									?>
										<option value="<?php echo $user["id"] . "-" . $user["full_name"]; ?>"><?php echo $user["full_name"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="description" class="control-label">Description:</label>
							<div>
								<textarea maxlength="140" class="form-control" id="description_insert" placeholder="Enter description" name="description"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button id="bt-add-task-dialog" type="submit" class="btn btn-primary">Insert</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-delete-task" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Delete Task</h4>
			</div>
			<form id="delete-task-form" action="<?php echo base_url() ?>project/deleteTask" onclick="$('#delete-task-form').validationEngine('hide')">
				<input type="hidden" value="" class="form-control" id="id_task_delete_form" name="taskId">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-delete-task" style="display:none;"></div>
					<div class="alert alert-success" id="success-delete-task" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Delete the task : <b><i id="task_name"></i></b> ?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button id="bt-delete-task-dialog" type="submit" class="btn btn-primary">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="<?php echo HTTP_LIB_PATH; ?>tinymce/tinymce.min.js"></script>

<script>
	var projectArr = <?php echo json_encode($project) ?>;
	var taskId = "<?php echo $taskId; ?>";
	var role = "<?php echo $this->session->userdata("role"); ?>";
	tinymce.init({selector: 'textarea.form-control',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
        relative_urls: false,
         

    height: "100",
    width: "520",
	entity_encoding : "raw"
    });
	
</script>

<?php
$arr['pluginsJquery'] = array(
	HTTP_LIB_PATH . "validationEngine/js/jquery.validationEngine.js",
	HTTP_LIB_PATH . "validationEngine/js/languages/jquery.validationEngine-en.js",
	HTTP_LIB_PATH . "chosen/chosen.jquery.js",
	HTTP_LIB_PATH . "switch/js/bootstrap-switch.min.js",
	HTTP_LIB_PATH . "moment/moment.min.js",
	HTTP_LIB_PATH . "bootstrap/js/bootstrap-datetimepicker.js",
	HTTP_JS_PATH . "project.js"
);
$this->load->view('viewFooter', $arr);
?>