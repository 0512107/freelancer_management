<?php 
	$arr['pageTitle'] = "Update Password";
	$arr['pluginsCSS'] = array(
		HTTP_LIB_PATH . "validationEngine/css/validationEngine.jquery.css"
	);
	$this->load->view('viewHeader', $arr);
?>

<header class="head" style="border-left: 1px solid rgba(0, 0, 0, 0.85);">
	<div class="main-bar">
		<div style="float:left;">
			<h3><i class="fa fa-user-circle-o"></i>&nbsp; Update Password</h3>
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
						<h5>Update Password</h5>
					</header>
					<form id="update-password-form" action="<?php echo base_url() ?>login/update_pass" onclick="$('#update-password-form').validationEngine('hide')">
						<div id="collapse4" class="body">
							<div class="alert alert-danger" id="error-update-pass" style="display:none;"></div>
							<div class="alert alert-success" id="success-update-pass" style="display:none;"></div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="old_pass">Old Password:</label>
									<input type="password" class="validate[required] form-control" id="old_pass" placeholder="Enter Old Password" name="old_pass">
								</div>
								<div class="form-group">
									<label for="first_name">New Password:</label>
									<input type="password" class="validate[required] form-control" id="new_pass" placeholder="Enter New Password" name="new_pass">
								</div>
								<div class="form-group">
									<label for="email">Confirm Password:</label>
									<input type="password" class="validate[required,equals[new_pass]] form-control" id="confirm_pass" placeholder="Type password again" name="confirm_pass">
								</div>
								<div class="form-group">
									<button id="update-password-bt" class="btn btn-lg btn-primary" type="submit">Update</button>
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

<?php
$arr['pluginsJquery'] = array(
	HTTP_LIB_PATH . "validationEngine/js/jquery.validationEngine.js",
	HTTP_LIB_PATH . "validationEngine/js/languages/jquery.validationEngine-en.js",
	HTTP_JS_PATH . "user/update_pass.js"
);
$this->load->view('viewFooter', $arr);
?>