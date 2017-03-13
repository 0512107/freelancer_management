$(document).ready(function() {
	$('#update-password-bt').on("click", function(e) {
		$('#update-password-form').validationEngine({
			ajaxFormValidationMethod: 'post',
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation : beforeCallUpdatePassword,
			onAjaxFormComplete: ajaxValidationCallbackUpdatePassword
		});
		$('#update-password-bt').off('click');		
	});
});

function beforeCallUpdatePassword(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdatePassword(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-pass').html(json.message);
		$('#error-update-pass').show();
		$('#success-update-pass').hide();
		if (json.field == "old_pass") {
			$("#old_pass").css("border", "1px solid red");
		}		
	} else if (json.result == 'success'){
		$('#success-update-pass').html(json.message);
		$('#success-update-pass').show();
		$('#error-update-pass').hide();
		$("#update-password-form input").css("border", "1px solid #ccc");
	}
	
	$.LoadingOverlay("hide");
}