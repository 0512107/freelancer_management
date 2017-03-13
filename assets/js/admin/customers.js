$(document).ready(function(){
	var indexColumn = 0;
	var table = $('#list-customer')
	.on('preXhr.dt', function ( e, settings, data ) {
        $.LoadingOverlay("show");
		indexColumn = 0;
    })
	.DataTable( {
		"processing": true,
        "serverSide": true,
		ajax: {
			url: base_url + 'admin/customers/get_customers',
			type: 'POST',
			dataType: "json"
		},
		columns: [
			{"data" : ""},
			{"data" : "last_name"},
			{"data" : "first_name"},
			{"data" : "full_name"},
			{"data" : "email"},
			{"data" : "phone"},
			{"data" : "description"},
			{"data" : ""}
		],
		"pageLength": 50,
		'sort': false,
		"columnDefs": [
			{
				"render": function($data, type, row) {
					return indexColumn = indexColumn + 1;
				},
				"targets": 0
			},
			{
				"render": function ( data, type, row ) {
					return "<button type='button' class='btn btn-primary update-customer' id-customer='" + row['id'] + "'> Update </button>&nbsp; <button class='btn btn-danger delete-customer' id-customer='" + row['id'] + "'>Delete</a>"
				},
				"targets": 7
			}
		],
		fnDrawCallback: function(data) { 
			$.LoadingOverlay("hide"); console.log(data);
			if (data["start"] == 0) {
				
			}
			
		},
		"scrollX": true
    } );
	
	$('#bt-add-customer-dialog').on("click", function(e) {
		$('#add-customer-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallAddCustomerDialog,
			onAjaxFormComplete: ajaxValidationCallbackAddCustomerDialog
		});
		$('#bt-add-customer-dialog').off('click');		
	});
	
	$('#list-customer tbody').on( 'click', '.update-customer', function () {
        var data = table.row( $(this).parents('tr') ).data();
		$("#last_name_update").val(data['last_name']);
		$("#first_name_update").val(data['first_name']);
		$("#email_update").val(data['email']);
		$("#phone_update").val(data['phone']);
		tinymce.get('description_update').setContent(decodeHtml(data['description']));
		$('#modal-update-customer').modal({
			show: 'true'
		});
    } );
	
	$('#list-customer tbody').on( 'click', '.delete-customer', function () {
        var data = table.row( $(this).parents('tr') ).data();
		$("#email_user").html(data["email"]);
		$("#id_delete_form").val(data["id"]);
		$("#email_delete_form").val(data["email"]);
		$('#modal-delete-customer').modal({
			show: 'true'
		});
    } );
	
	$('#bt-update-customer-dialog').on("click", function(e) {
		$('#update-customer-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallUpdateCustomerDialog,
			onAjaxFormComplete: ajaxValidationCallbackUpdateCustomerDialog
		});
		$('#bt-update-customer-dialog').off('click');		
	});
	
	$('#bt-delete-customer-dialog').on("click", function(e) {
		$('#delete-customer-form').validationEngine({
			ajaxFormValidationMethod: 'post',
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation : beforeCallDeleteCustomerDialog,
			onAjaxFormComplete: ajaxValidationCallbackDeleteCustomerDialog
		});
		$('#bt-delete-customer-dialog').off('click');		
	});
});

function beforeCallDeleteCustomerDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackDeleteCustomerDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-customer').html(json.message);
		$('#error-update-customer').show();
		$('#success-update-customer').hide();
	} else if (json.result == 'success'){
		$('#success-update-customer').html(json.message);
		$('#success-update-customer').show();
		$('#error-update-customer').hide();
		window.location.href = base_url + "admin/customers";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallUpdateCustomerDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdateCustomerDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-customer').html(json.message);
		$('#error-update-customer').show();
		$('#success-update-customer').hide();
	} else if (json.result == 'success'){
		$('#success-update-customer').html(json.message);
		$('#success-update-customer').show();
		$('#error-update-customer').hide();
		window.location.href = base_url + "admin/customers";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallAddCustomerDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackAddCustomerDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-validate').html(json.message);
		$('#error-validate').show();
		$('#success-forgot-pass').hide();
		if (json.field == "email") {
			$("#email").css("border", "1px solid red");
		}
	} else if (json.result == 'success'){
		$('#success-forgot-pass').html(json.message);
		$('#success-forgot-pass').show();
		$('#error-validate').hide();
		$("#add-customer-form input").css("border", "1px solid #ccc");
		window.location.href = base_url + "admin/customers";
	}
	
	$.LoadingOverlay("hide");
}

function decodeHtml(str) {
    return String(str).replace(/&amp/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}