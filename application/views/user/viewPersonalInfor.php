<?php 
	$arr['pageTitle'] = "Personal Information";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<h3><i class="fa fa-user-circle-o"></i>&nbsp; Personal Infor</h3>
	</div>
</header>

<div class="outer">
	<div class="inner bg-light lter">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table"></i></div>
						<h5>Personal Infor</h5>
					</header>
					<form id="update-personal-form" action="<?php echo base_url() ?>user/personal_infor/update" onclick="$('#update-personal-form').validationEngine('hide')">
						<div id="collapse4" class="body">
							<div class="alert alert-danger" id="error-add-user" style="display:none;"></div>
							<div class="alert alert-success" id="success-add-user" style="display:none;"></div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="last_name">Last Name:</label>
									<input value="<?php echo $infor['last_name']; ?>" type="text" class="validate[required] form-control" id="last_name" placeholder="Enter Last Name" name="last_name">
								</div>
								<div class="form-group">
									<label for="first_name">First Name:</label>
									<input value="<?php echo $infor['first_name']; ?>" type="text" class="validate[required] form-control" id="first_name" placeholder="Enter First Name" name="first_name">
								</div>
								<div class="form-group">
									<label for="email">Email:</label>
									<input type="text" readonly value="<?php echo $infor['email']; ?>" class="validate[required,custom[email]] form-control" id="emailt" placeholder="Enter Email" name="email">
								</div>
								<div class="form-group">
									<label for="phone">Phone:</label>
									<input type="text" value="<?php echo $infor['phone']; ?>" class="form-control" id="phone" placeholder="Enter Phone" name="phone">
								</div>
							</div>
							
							<div class="col-lg-6">
								<?php if ($this->session->userdata('role') == "admin") { ?>
								<div class="form-group">
									<label for="role">Role:</label>
									<select name="role" id="role" class="form-control">
										<option <?php echo $infor['role'] =='user' ? 'selected=seleted' : '' ?> value="user">User</option>
										<option <?php echo $infor['role'] =='admin' ? 'selected=seleted' : '' ?> value="admin">Admin</option>
									</select>
								</div>
								<?php } ?>
								<div class="form-group">
									<label for="bank_name">Bank Name:</label>
									<input type="text" value="<?php echo $infor['bank_name']; ?>" class="validate[required] form-control" id="bank_name" placeholder="Enter Bank Name" name="bank_name">
								</div>
								<div class="form-group">
									<label for="bank_number">Bank Number:</label>
									<input type="text" value="<?php echo $infor['bank_number']; ?>" class="validate[required] form-control" id="bank_number" placeholder="Enter Bank Number" name="bank_number">
								</div>
								<div class="form-group">
									<label for="address">Address:</label>
									<input type="text" value="<?php echo $infor['address']; ?>" class="form-control" id="address" placeholder="Enter Address" name="address">
								</div>
							</div>
							
							<div style="clear:both;"></div>
							
							<div class="col-lg-12">
								<div class="form-group">
									<label for="first_name" class="control-label">Description:</label>
									<div>
										<textarea maxlength="140" class="form-control" id="description_insert" placeholder="Enter description" name="description"><?php echo $infor['description']; ?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<button id="bt-edit-personal-infor" type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</div>
					</form>
					<div style="clear:both;"></div>
				</div>
			</div>
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
	HTTP_LIB_PATH . "validationEngine/js/jquery.validationEngine.js",
	HTTP_LIB_PATH . "validationEngine/js/languages/jquery.validationEngine-en.js",
	HTTP_JS_PATH . "user/personal_infor.js"
);
$this->load->view('viewFooter', $arr);
?>