$(document).ready(function(){
	var indexColumn = 0;
	var tableUser = $('#list-user')
	.on('preXhr.dt', function ( e, settings, data ) {
        $.LoadingOverlay("show");
		indexColumn = 0;
    })
	.DataTable( {
		"processing": true,
        "serverSide": true,
		ajax: {
			url: base_url + 'admin/users/get_users',
			type: 'POST',
			dataType: "json"
		},
		columns: [
			{"data" : "full_name"},
			{"data" : "email"},
			{"data" : "phone"},
			{"data" : "bank_name"},
			{"data" : "bank_number"},
			{"data" : ""}
		],
		"pageLength": 50,
		'sort': false,
		"columnDefs": [
			{
				"render": function ( data, type, row ) {
					return "<button type='button' class='btn btn-info detail-user'> Detail </button>&nbsp; <button type='button' class='btn btn-primary update-user'> Update </button>&nbsp; <button class='btn btn-danger delete-user'>Delete</a>"
				},
				"targets": 5
			}
		],
		fnDrawCallback: function(data) { 
			$.LoadingOverlay("hide");
		},
		scrollX: true
    } );
	
	$('#bt-add-user-dialog').on("click", function(e) {
		$('#add-user-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallAddUserDialog,
			onAjaxFormComplete: ajaxValidationCallbackAddUserDialog
		});
		$('#bt-add-customer-dialog').off('click');		
	});
	
	$('#list-user tbody').on( 'click', '.detail-user', function () {
        var data = tableUser.row( $(this).parents('tr') ).data();
		$("#last_name_detail").val(data['last_name']);
		$("#first_name_detail").val(data['first_name']);
		$("#email_detail").val(data['email']);
		$("#phone_detail").val(data['phone']);
		if ($("#role_update").length > 0) {
			$("#role_detail").val(data['role'])
		}
		$("#address_detail").val(data['address']);
		$("#bank_number_detail").val(data['bank_number']);
		$("#bank_name_detail").val(data['bank_name']);
		tinymce.get('description_detail').setContent(decodeHtml(data['description']));
		$('#modal-detail-user').modal({
			show: 'true'
		});
    } );
	
	$('#list-user tbody').on( 'click', '.update-user', function () {
        var data = tableUser.row( $(this).parents('tr') ).data();
		$("#last_name_update").val(data['last_name']);
		$("#first_name_update").val(data['first_name']);
		$("#email_update").val(data['email']);
		$("#phone_update").val(data['phone']);
		if ($("#role_update").length > 0) {
			$("#role_update").val(data['role'])
		}
		$("#address_update").val(data['address']);
		$("#bank_number_update").val(data['bank_number']);
		$("#bank_name_update").val(data['bank_name']);
		tinymce.get('description_update').setContent(decodeHtml(data['description']));
		$('#modal-update-user').modal({
			show: 'true'
		});
    } );
	
	$('#list-user tbody').on( 'click', '.delete-user', function () {
        var data = tableUser.row( $(this).parents('tr') ).data();
		$("#email_user").html(data["email"]);
		$("#id_delete_form").val(data["id"]);
		$("#email_delete_form").val(data["email"]);
		$('#modal-delete-user').modal({
			show: 'true'
		});
    } );
	
	$('#bt-update-user-dialog').on("click", function(e) {
		$('#update-user-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallUpdateUserDialog,
			onAjaxFormComplete: ajaxValidationCallbackUpdateUserDialog
		});
		$('#bt-update-user-dialog').off('click');		
	});
	
	$('#bt-delete-user-dialog').on("click", function(e) {
		$('#delete-user-form').validationEngine({
			ajaxFormValidationMethod: 'post',
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation : beforeCallDeleteUserDialog,
			onAjaxFormComplete: ajaxValidationCallbackDeleteUserDialog
		});
		$('#bt-delete-user-dialog').off('click');		
	});
});

function beforeCallDeleteUserDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackDeleteUserDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-delete-user').html(json.message);
		$('#error-delete-user').show();
		$('#success-delete-user').hide();
	} else if (json.result == 'success'){
		$('#success-delete-user').html(json.message);
		$('#success-delete-user').show();
		$('#error-delete-user').hide();
		window.location.href = base_url + "admin/users";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallUpdateUserDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdateUserDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-customer').html(json.message);
		$('#error-update-customer').show();
		$('#success-update-customer').hide();
	} else if (json.result == 'success'){
		$('#success-update-customer').html(json.message);
		$('#success-update-customer').show();
		$('#error-update-customer').hide();
		window.location.href = base_url + "admin/users";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallAddUserDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackAddUserDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-add-user').html(json.message);
		$('#error-add-user').show();
		$('#success-add-user').hide();
		if (json.field == "email") {
			$("#email_insert").css("border", "1px solid red");
		}
	} else if (json.result == 'success'){
		$('#success-add-user').html(json.message);
		$('#success-add-user').show();
		$('#error-add-user').hide();
		$("#add-user-form input").css("border", "1px solid #ccc");
		window.location.href = base_url + "admin/users";
	}
	
	$.LoadingOverlay("hide");
}

function decodeHtml(str) {
    return String(str).replace(/&amp/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}