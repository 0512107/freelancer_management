<?php 
	$arr['pageTitle'] = "List Customer";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "datatables/3/dataTables.bootstrap.css",
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<div style="float:left;">
			<h3><i class="fa fa-user-circle-o"></i>&nbsp; Customers</h3>
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
						<h5>List Customer</h5>
						<div style="padding-right: 10px; padding-top:3px;">
							<button type='button' class='btn btn-success add-customer' data-toggle="modal" data-target="#modal-add-new-customer"> Add new customer</button>
						</div>
					</header>
				  
					<div id="collapse4" class="body">
						<table id="list-customer" class="table table-bordered table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>Phone</th>
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

<div id="modal-add-new-customer" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Add New Customer</h4>
			</div>
			<form id="add-customer-form" action="<?php echo base_url() ?>admin/customers/insert" onclick="$('#add-customer-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-validate" style="display:none;"></div>
					<div class="alert alert-success" id="success-forgot-pass" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Last Name:</label>
						<input type="text" class="validate[required] form-control" id="last_name" placeholder="Enter Last Name" name="last_name">
					</div>
					<div class="form-group">
						<label for="first_name">First Name:</label>
						<input type="text" class="validate[required] form-control" id="first_name" placeholder="Enter First Name" name="first_name">
					</div>
					<div class="form-group">
						<label for="first_name">Email:</label>
						<input type="text" class="validate[required,custom[email]] form-control" id="email" placeholder="Enter Email" name="email">
					</div>
					<div class="form-group">
						<label for="first_name">Phone:</label>
						<input type="text" class="form-control" id="phone" placeholder="Enter Phone" name="phone">
					</div>
					<div class="form-group">
						<label for="first_name" class="control-label">Description:</label>
						<div>
							<textarea maxlength="140" class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button id="bt-add-customer-dialog" type="submit" class="btn btn-primary">Insert</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-detail-customer" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Customer Detail</h4>
			</div>			
			<div class="modal-body">
				<div class="form-group">
					<label for="last_name">Last Name:</label>
					<input readonly type="text" class="form-control" id="last_name_detail" name="last_name">
				</div>
				<div class="form-group">
					<label for="first_name">First Name:</label>
					<input readonly type="text" class="form-control" id="first_name_detail" name="first_name">
				</div>
				<div class="form-group">
					<label for="first_name">Email:</label>
					<input readonly type="text" class="form-control" id="email_detail" name="email">
				</div>
				<div class="form-group">
					<label for="first_name">Phone:</label>
					<input readonly type="text" class="form-control" id="phone_detail" name="phone">
				</div>
				<div class="form-group">
					<label for="description" class="control-label">Description:</label>
					<div>
						<textarea readonly maxlength="140" class="form-control" id="description_detail" placeholder="Enter description" name="description"></textarea>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="modal-update-customer" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Update Customer</h4>
			</div>
			<form id="update-customer-form" action="<?php echo base_url() ?>admin/customers/update" onclick="$('#update-customer-form').validationEngine('hide')">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-update-customer" style="display:none;"></div>
					<div class="alert alert-success" id="success-update-customer" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Last Name:</label>
						<input type="text" class="validate[required] form-control" id="last_name_update" placeholder="Enter Last Name" name="last_name">
					</div>
					<div class="form-group">
						<label for="first_name">First Name:</label>
						<input type="text" class="validate[required] form-control" id="first_name_update" placeholder="Enter First Name" name="first_name">
					</div>
					<div class="form-group">
						<label for="first_name">Email:</label>
						<input readonly type="text" class="validate[required,custom[email]] form-control" id="email_update" placeholder="Enter Email" name="email">
					</div>
					<div class="form-group">
						<label for="first_name">Phone:</label>
						<input type="text" class="form-control" id="phone_update" placeholder="Enter Phone" name="phone">
					</div>
					<div class="form-group">
						<label for="first_name" class="control-label">Description:</label>
						<div>
							<textarea maxlength="140" class="form-control" id="description_update" placeholder="Enter description" name="description"></textarea>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button id="bt-update-customer-dialog" type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal-delete-customer" class="modal fade custom-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold;">Delete Customer</h4>
			</div>
			<form id="delete-customer-form" action="<?php echo base_url() ?>admin/customers/delete" onclick="$('#delete-customer-form').validationEngine('hide')">
				<input type="hidden" value="" class="form-control" id="email_delete_form" name="email">
				<input type="hidden" value="" class="form-control" id="id_delete_form" name="id">
				<div class="modal-body">
					<div class="alert alert-danger" id="error-update-customer" style="display:none;"></div>
					<div class="alert alert-success" id="success-update-customer" style="display:none;"></div>
					<div class="form-group">
						<label for="last_name">Delete the user : <i id="email_user"></i> ?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button id="bt-delete-customer-dialog" type="submit" class="btn btn-primary">Delete</button>
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
	HTTP_JS_PATH . "admin/customers.js"
);
$this->load->view('viewFooter', $arr);
?>