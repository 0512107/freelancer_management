<?php 
	$arr['pageTitle'] = "List Project";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "datatables/3/dataTables.bootstrap.css",
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css",
		HTTP_LIB_PATH . "switch/css/bootstrap3/bootstrap-switch.min.css",
		HTTP_LIB_PATH . "chosen/chosen.min.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<div style="float:left;">
			<h3><i class="fa fa-user-circle-o"></i>&nbsp; Projects</h3>
		</div>
		<div style="float:right;">
			<div class="btn-group">
				<a data-placement="bottom" data-original-title="Show / Hide Left" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
				  <i class="fa fa-bars"></i>
				</a> 
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</header>

<div class="outer">
	<div class="inner bg-light lter">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table"></i></div>
						<h5>List Project</h5>
						<div style="padding-right: 10px; padding-top:3px;">
							<button type='button' class='btn btn-success add-project' data-toggle="modal" data-target="#modal-add-new-project"> Add new project</button>
						</div>
					</header>
					
					<div id="collapse4" class="body">
						<table id="list-project" class="table table-bordered table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>Code</th>
									<th>Name</th>
									<th>Project Owner</th>
									<th>Customer Name</th>
									<th>Members</th>
									<th>Complete</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-add-new-project" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Add New Project</h4>
			</div>
			<form id="add-project-form" action="<?php echo base_url() ?>admin/projects/insert" onclick="$('#add-project-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-add-project" style="display:none;"></div>
					<div class="alert alert-success" id="success-add-project" style="display:none;"></div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="code">Code:</label>
							<input type="text" class="validate[required] form-control" id="code_insert" placeholder="Enter Code Project" name="code">
						</div>
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="text" class="validate[required] form-control" id="name_insert" placeholder="Enter Name Project" name="name">
						</div>
						
					</div>
					
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">Project Owner:</label>
							<input readonly value="<?php echo $this->session->userdata("full_name"); ?>" type="text" class="form-control" id="project_owner_name" name="project_owner_name">
							<input readonly value="<?php echo $this->session->userdata("id"); ?>" type="hidden" class="form-control" id="project_owner_id" name="project_owner_id">
						</div>
						<div class="form-group">
							<label for="customer">Customer:</label>
							<div style="width: 100%;">
								<select name="customer" id="customer_insert" class="form-control" data-placeholder="Choose a Customer...">
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
							<label for="customer">Members:</label>
							<div style="width: 100%;">
								<select multiple="multiple" name="members[]" id="members_insert" class="form-control" data-placeholder="Add member...">
									<option value=""></option>
									<?php 
										foreach($listUser as $key => $user) {
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
					<button id="bt-add-project-dialog" type="submit" class="btn btn-primary">Insert</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-detail-project" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Project Detail <font id="status-project"></font></h4>
			</div>
			<form id="detail-project-form">
				<div class="modal-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="code">Code:</label>
							<input readonly type="text" class="validate[required] form-control" id="code_detail" placeholder="Enter Code Project" name="code">
						</div>
						<div class="form-group">
							<label for="name">Name:</label>
							<input readonly type="text" class="validate[required] form-control" id="name_detail" placeholder="Enter Name Project" name="name">
						</div>
					</div>
					
					<div class="col-lg-6">
						<div class="form-group">
							<label for="email">Project Owner:</label>
							<input readonly value="" type="text" class="form-control" id="project_owner_name_detail" name="project_owner_name">
							<input readonly value="" type="hidden" class="form-control" id="project_owner_id_detail" name="project_owner_id">
						</div>
						<div class="form-group">
							<label for="customer">Customer:</label>
							<input readonly type="text" class="form-control" id="customer_detail" name="customer_detail">
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="customer">Members:</label>
							<div style="width: 100%;">
								<select readonly multiple="multiple" name="members[]" id="members_detail" class="form-control" data-placeholder="Add member...">
									<option value=""></option>
									<?php 
										foreach($listUser as $key => $user) {
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
								<textarea maxlength="140" class="form-control" id="description_detail" placeholder="Enter description" name="description"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button id="bt-detail-project-dialog" type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</form>
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
							<label for="customer">Members:</label>
							<div style="width: 100%;">
								<select multiple="multiple" name="members[]" id="members_update" class="form-control" data-placeholder="Add member...">
									<option value=""></option>
									<?php 
										foreach($listUser as $key => $user) {
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
						<label for="last_name">Delete the project : <b><i id="code_project"></i></b> ?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button id="bt-delete-project-dialog" type="submit" class="btn btn-primary">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo HTTP_LIB_PATH; ?>tinymce/tinymce.min.js"></script>

<script>

    tinymce.init({selector: 'textarea',
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
	HTTP_LIB_PATH . "datatables/jquery.dataTables.js",
	HTTP_LIB_PATH . "datatables/3/dataTables.bootstrap.js",
	HTTP_LIB_PATH . "validationEngine/js/jquery.validationEngine.js",
	HTTP_LIB_PATH . "validationEngine/js/languages/jquery.validationEngine-en.js",
	HTTP_LIB_PATH . "chosen/chosen.jquery.js",
	HTTP_LIB_PATH . "switch/js/bootstrap-switch.min.js",
	HTTP_JS_PATH . "admin/projects.js"
);
$this->load->view('viewFooter', $arr);
?>