<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login Page</title>
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
				<div id="login" class="tab-pane active">
					<form id="login-form" action="<?php echo base_url() ?>login/do_login" onclick="$('#login-form').validationEngine('hide')">
						<p class="text-muted text-center">Enter your email and password</p>
						<div class="alert alert-danger" id="error-validate" style="display:none;"></div>
						<input type="text" placeholder="Email" class="validate[required,custom[email]] form-control top" id="email" name="email">
						<input type="password" placeholder="Password" class="validate[required] form-control bottom" id="pass" name="pass">
						<div class="checkbox">
						  <label><input type="checkbox" id="remember_me">Remember Me</label>
						</div>
						<button id="bt-sign-in" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					</form>
				</div>
				
				<div id="forgot" class="tab-pane">
					<form id="forgot-pass-form" action="<?php echo base_url() ?>login/forgot_password">
						<p class="text-muted text-center">Enter your valid e-mail</p>
						<div class="alert alert-danger" id="error-forgot-pass" style="display:none;"></div>
						<div class="alert alert-success" id="success-forgot-pass" style="display:none;"></div>
						<input type="text" placeholder="mail@domain.com" class="validate[required,custom[email]] form-control" name="email">
						<br>
						<button id="recover-button" class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
					</form>
				</div>
			</div>
			<hr>
			<div class="text-center">
				<ul class="list-inline">
				  <li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
				  <li><a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a></li>
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
			
			function ajaxValidationCallback(status, form, json, options){console.log(json);
				if (json.result == 'error') {
					$('#error-validate').html(json.message);
					$('#error-validate').show();
				} else if (json.result == 'success'){
					window.location.href = base_url + "dashboard";
				}
				
				$.LoadingOverlay("hide");
			}
			
			function beforeCallForgotForm(form, options){				
				$.LoadingOverlay("show");
				return true;
			}
			
			function ajaxValidationForgotFormCallback(status, form, json, options){
				console.log(json);
				if (json.result == 'error') {
					$('#error-forgot-pass').html(json.message);
					$('#error-forgot-pass').show();
					$('#success-forgot-pass').hide();
				} else if (json.result == 'success') {
					$('#success-forgot-pass').html(json.message);
					$('#success-forgot-pass').show();
					$('#error-forgot-pass').hide();
				}
				$.LoadingOverlay("hide");
			}
			
			(function($) {
				$(document).ready(function() {
					$('.list-inline li > a').click(function() {
						var activeForm = $(this).attr('href') + ' > form';
						$(activeForm).addClass('animated fadeIn');
					
						setTimeout(function() {
							$(activeForm).removeClass('animated fadeIn');
						}, 1000);
					});
					
					$('#bt-sign-in').on("click", function(e) {
						$('#login-form').validationEngine('attach',{
						ajaxFormValidation: true,
						maxErrorsPerField:1,
						ajaxFormValidationMethod: 'post',
						onBeforeAjaxFormValidation : beforeCall,
						onAjaxFormComplete: ajaxValidationCallback});
						$('#bt-sign-in').off('click');						
					});
					
					$('#recover-button').on("click", function(e) {
						$('#forgot-pass-form').validationEngine('attach',{
						ajaxFormValidation: true,
						maxErrorsPerField:1,
						ajaxFormValidationMethod: 'post',
						onBeforeAjaxFormValidation : beforeCallForgotForm,
						onAjaxFormComplete: ajaxValidationForgotFormCallback});
						$('#recover-button').off('click');						
					});
				});
				
				if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#remember_me').attr('checked', 'checked');
                    $('#email').val(localStorage.usrname);
                    $('#pass').val(localStorage.pass);
                } else {
                    $('#remember_me').removeAttr('checked');
                    $('#email').val('');
                    $('#pass').val('');
                }

                $('#remember_me').click(function() {
                    if ($('#remember_me').is(':checked')) {
                        localStorage.usrname = $('#email').val();
                        localStorage.pass = $('#pass').val();
                        localStorage.chkbx = $('#remember_me').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.pass = '';
                        localStorage.chkbx = '';
                    }
                });
		})(jQuery);
		  
		
		</script>
	</body>
</html>