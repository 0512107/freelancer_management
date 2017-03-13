<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>New Password</title>
		<meta name="msapplication-TileColor" content="#5bc0de" />
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css">
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>animate/animate.min.css">
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>validationEngine/css/validationEngine.jquery.css">
		<script type="text/javascript">
			var base_url = '<?php echo base_url() ?>';
		</script>
	</head>
	
	<body class="login">
		<div class="form-signin">
			<div class="text-center">
				<img class="logo" src="<?php echo HTTP_IMAGES_PATH; ?>logo.png" alt="PM Logo">
			</div>
			<hr>
			<div class="tab-content">
				<?php if (!empty($code)) { ?>
				<div id="new_password" class="tab-pane active">
					<form id="new-pass-form" action="<?php echo base_url() ?>/login/new_password/<?php echo $code;?>" onclick="$('#new-pass-form').validationEngine('hide')">
						<p class="text-muted text-center">Enter your new password</p>
						<div class="alert alert-danger" id="error-validate" style="display:none;"></div>
						<div class="alert alert-success" id="success-forgot-pass" style="display:none;"></div>
						<div class="form-group">
							<label for="password">New Password:</label>
							<input type="password" class="validate[required] form-control top" id="password" placeholder="Enter password" name="password">
						</div>
						<div class="form-group">
							<label for="confirm_password">Confirm Password:</label>
							<input type="password" class="validate[required,equals[password]] form-control bottom" id="confirm_password" placeholder="Confirm password" name="confirm_password">
						</div>
						<button id="bt-continue" class="btn btn-lg btn-primary btn-block" type="submit">Continue</button>
					</form>
				</div>
				<?php } else { ?>
					<div id="new_password" class="tab-pane active">
						<h3>Error: Whoops! There was an error</h3>
					</div>
				<?php } ?>
			</div>
			<hr>
			<div class="text-center">
				<ul class="list-inline">
					<li><a class="text-muted" href="<?php echo base_url() ?>login">Login</a></li>				  
				</ul>
			</div>
		</div>
		<script src="<?php echo HTTP_LIB_PATH ?>jquery/jquery.min.js"></script>
		<script src="<?php echo HTTP_LIB_PATH ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo HTTP_LIB_PATH ?>validationEngine/js/jquery.validationEngine.js"></script>
		<script src="<?php echo HTTP_LIB_PATH ?>validationEngine/js/languages/jquery.validationEngine-en.js"></script>
		<script src="<?php echo HTTP_LIB_PATH ?>loading-overlay/loadingoverlay.js"></script>
		<script type="text/javascript">			
			function beforeCall(form, options){				
				$.LoadingOverlay("show");
				return true;
			}
			
			function ajaxValidationCallback(status, form, json, options){
				if (json.result == 'error') {
					$('#error-validate').html(json.message);
					$('#error-validate').show();
					$('#success-forgot-pass').hide();
				} else if (json.result == 'success'){
					$('#success-forgot-pass').html(json.message);
					$('#success-forgot-pass').show();
					$('#error-validate').hide();
				}
				
				$.LoadingOverlay("hide");
			}
			(function($) {
				$(document).ready(function() {
					$('#bt-continue').on("click", function(e) {
						$('#new-pass-form').validationEngine('attach',{
						ajaxFormValidation: true,
						maxErrorsPerField:1,
						ajaxFormValidationMethod: 'post',
						onBeforeAjaxFormValidation : beforeCall,
						onAjaxFormComplete: ajaxValidationCallback});
						$('#bt-continue').off('click');						
					});
				});
			})(jQuery);
		</script>
	</body>
</html>