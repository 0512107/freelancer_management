<?php 
	$arr['pageTitle'] = "List User";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "datatables/3/dataTables.bootstrap.css",
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<h3><i class="fa fa-user-circle-o"></i>&nbsp; Users</h3>
	</div>
</header>

<div class="outer">
	<div class="inner bg-light lter">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table"></i></div>
						<h5>List User</h5>
						<div style="padding-right: 10px; padding-top:3px;">
							<button type='button' class='btn btn-success add-user' data-toggle="modal" data-target="#modal-add-new-user"> Add new user</button>
						</div>
					</header>
					
					<div id="collapse4" class="body">
						<table id="list-user" class="table table-bordered table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>Last Name</th>
									<th>First Name</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Bank Name</th>
									<th>Bank Number</th>
									<th>Role</th>
									<th>Address</th>
									<th>Description</th>
									<th>Operation</th>
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

<div id="modal-add-new-user" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Add New Customer</h4>
			</div>
			<form id="add-user-form" action="<?php echo base_url() ?>users/insert" onclick="$('#add-user-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-add-user" style="display:none;"></div>
					<div class="alert alert-success" id="success-add-user" style="display:none;"></div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="last_name">Last Name:</label>
							<input type="text" class="validate[required] form-control" id="last_name_insert" placeholder="Enter Last Name" name="last_name">
						</div>
						<div class="form-group">
							<label for="first_name">First Name:</label>
							<input type="text" class="validate[required] form-control" id="first_name_insert" placeholder="Enter First Name" name="first_name">
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="text" class="validate[required,custom[email]] form-control" id="email_insert" placeholder="Enter Email" name="email">
						</div>
						<div class="form-group">
							<label for="phone">Phone:</label>
							<input type="text" class="form-control" id="phone_insert" placeholder="Enter Phone" name="phone">
						</div>
					</div>
					
					<div class="col-lg-6">
						<?php if ($this->session->userdata('role') == "admin") { ?>
						<div class="form-group">
							<label for="role">Role:</label>
							<select name="role" id="role_insert" class="form-control">
								<option value="user">User</option>
								<option value="admin">Admin</option>
							</select>
						</div>
						<?php } ?>
						<div class="form-group">
							<label for="bank_name">Bank Name:</label>
							<input type="text" class="validate[required] form-control" id="bank_name_insert" placeholder="Enter Bank Name" name="bank_name">
						</div>
						<div class="form-group">
							<label for="bank_number">Bank Number:</label>
							<input type="text" class="validate[required] form-control" id="bank_number_insert" placeholder="Enter Bank Number" name="bank_number">
						</div>
						<div class="form-group">
							<label for="address">Address:</label>
							<input type="text" class="form-control" id="address_insert" placeholder="Enter Address" name="address">
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="first_name" class="control-label">Description:</label>
							<div>
								<textarea maxlength="140" class="form-control" id="description_insert" placeholder="Enter description" name="description"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button id="bt-add-user-dialog" type="submit" class="btn btn-primary">Insert</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-update-user" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Update User</h4>
			</div>
			<form id="update-user-form" action="<?php echo base_url() ?>users/update" onclick="$('#update-user-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-update-user" style="display:none;"></div>
					<div class="alert alert-success" id="success-update-user" style="display:none;"></div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="last_name">Last Name:</label>
							<input type="text" class="validate[required] form-control" id="last_name_update" placeholder="Enter Last Name" name="last_name">
						</div>
						<div class="form-group">
							<label for="first_name">First Name:</label>
							<input type="text" class="validate[required] form-control" id="first_name_update" placeholder="Enter First Name" name="first_name">
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input readonly type="text" class="validate[required,custom[email]] form-control" id="email_update" placeholder="Enter Email" name="email">
						</div>
						<div class="form-group">
							<label for="phone">Phone:</label>
							<input type="text" class="form-control" id="phone_update" placeholder="Enter Phone" name="phone">
						</div>
					</div>
					
					<div class="col-lg-6">
						<?php if ($this->session->userdata('role') == "admin") { ?>
						<div class="form-group">
							<label for="role">Role:</label>
							<select name="role" id="role_update" class="form-control">
								<option value="user">User</option>
								<option value="admin">Admin</option>
							</select>
						</div>
						<?php } ?>
						<div class="form-group">
							<label for="bank_name">Bank Name:</label>
							<input type="text" class="validate[required] form-control" id="bank_name_update" placeholder="Enter Bank Name" name="bank_name">
						</div>
						<div class="form-group">
							<label for="bank_number">Bank Number:</label>
							<input type="text" class="validate[required] form-control" id="bank_number_update" placeholder="Enter Bank Number" name="bank_number">
						</div>
						<div class="form-group">
							<label for="address">Address:</label>
							<input type="text" class="form-control" id="address_update" placeholder="Enter Address" name="address">
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="first_name" class="control-label">Description:</label>
							<div>
								<textarea maxlength="140" class="form-control" id="description_update" placeholder="Enter description" name="description"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button id="bt-update-user-dialog" type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-delete-user" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Delete User</h4>
			</div>
			<form id="delete-user-form" action="<?php echo base_url() ?>users/delete" onclick="$('#delete-user-form').validationEngine('hide')">
				<input type="hidden" value="" class="form-control" id="email_delete_form" name="email">
				<input type="hidden" value="" class="form-control" id="id_delete_form" name="id">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-delete-user" style="display:none;"></div>
					<div class="alert alert-success" id="success-delete-user" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Delete the user : <i id="email_user"></i> ?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button id="bt-delete-user-dialog" type="submit" class="btn btn-primary">Delete</button>
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
	HTTP_JS_PATH . "users.js"
);
$this->load->view('viewFooter', $arr);
?>