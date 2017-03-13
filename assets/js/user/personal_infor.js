$(document).ready(function() {
	$('#bt-edit-personal-infor').on("click", function(e) {
		$('#update-personal-form').validationEngine({
			ajaxFormValidationMethod: 'post',
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation : beforeCallUpdatePersonalInfor,
			onAjaxFormComplete: ajaxValidationCallbackUpdatePersonalInfor
		});
		$('#bt-edit-personal-infor').off('click');		
	});
});

function beforeCallUpdatePersonalInfor(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdatePersonalInfor(status, form, json, options){
	if (json.result == 'error') {
		$('#error-delete-user').html(json.message);
		$('#error-delete-user').show();
		$('#success-delete-user').hide();
	} else if (json.result == 'success'){
		$('#success-delete-user').html(json.message);
		$('#success-delete-user').show();
		$('#error-delete-user').hide();
	}
	
	$.LoadingOverlay("hide");
}