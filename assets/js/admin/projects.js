$(document).ready(function(){
	var indexColumn = 0;
	var tableProject = $('#list-project')
	.on('preXhr.dt', function ( e, settings, data ) {
        $.LoadingOverlay("show");
		indexColumn = 0;
    })
	.DataTable( {
		"processing": true,
        "serverSide": true,
		ajax: {
			url: base_url + 'admin/projects/get_projects',
			type: 'POST',
			dataType: "json"
		},
		columns: [
			{"data" : "code"},
			{"data" : "name"},
			{"data" : "project_owner_name"},
			{"data" : "customer_name"},
			{"data" : "is_completed", "text-align" : "center"},
			{"data" : ""}
		],
		"pageLength": 50,
		'sort': false,
		"columnDefs": [
			{
				"render": function ( data, type, row ) {
					var htmlLi = "";
					if (row["members"].length > 0) {
						var objMembers = $.parseJSON(row['members']);
						$.each( objMembers, function( key, value ) {
							htmlLi = htmlLi + '<li class="search-choice"><span>' + value.name + "</span></li>";
						});
					}
					var html = '<div class="chosen-container chosen-container-multi" style="width: 100%;"><ul class="chosen-choices">' + htmlLi + '</ul></div>';
					return html;
				},
				"targets": 4
			},
			{
				"render": function ( data, type, row ) {
					if (data == "1") {
						return '<i class="fa fa-check" aria-hidden="true" style="margin-top: 10px;"></i>'
					} else {
						return ""
					}
					
				},
				"className": "column-is-completed",
				"targets": 5
			},
			{
				"render": function ( data, type, row ) {
					return "<button type='button' class='btn btn-info btn-sm detail-project'> Detail </button>&nbsp; <button type='button' class='btn btn-primary btn-sm update-project'> Update </button>&nbsp; <button class='btn btn-danger btn-sm delete-project'>Delete</a>"
				},
				"targets": 6
			}
		],
		fnDrawCallback: function(data) { 
			$.LoadingOverlay("hide");
		},
		scrollX: true,
		searchDelay: 1000
    } );
	
	$("#customer_insert").chosen({width: "100%"});
	$("#customer_update").chosen({width: "100%"});
	$("#members_insert").chosen({width: "100%"});
	$("#members_detail").chosen({width: "100%"});
	$("#members_update").chosen({width: "100%"});
	
	$('#bt-add-project-dialog').on("click", function(e) {
		$('#add-project-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallAddProjectDialog,
			onAjaxFormComplete: ajaxValidationCallbackAddProjectDialog
		});
		$('#bt-add-project-dialog').off('click');
	});
	
	$('#list-project tbody').on( 'click', '.detail-project', function () {
        var data = tableProject.row( $(this).parents('tr') ).data();
		$("#code_detail").val(data['code']);
		$("#name_detail").val(data['name']);
		$("#project_owner_name_detail").val(data['project_owner_name']);
		$("#project_owner_id_detail").val(data['project_owner_id']);
		$("#customer_detail").val(data['customer_name'])
		tinymce.get('description_detail').setContent(decodeHtml(data['description']));
		if (data["is_completed"] == 0 ) {
			$("#status-project").css("color", "#d43f3a");
			$("#status-project").html(" (Uncomplete Project) ");
		} else {
			$("#status-project").css("color", "#4cae4c");
			$("#status-project").html(" (Completed Project) ");
		}
		
		$("#members_detail option").prop('selected', false);
		$('#members_detail').prop('disabled', true);
		if (data['members'].length > 0 ) {
			var objMembers = $.parseJSON(data['members']);
			$.each( objMembers, function( key, value ) {
				$("#members_detail option[value='" + value.id + "-" + value.name + "']").prop('selected', true);
			});
		}		
		$('#members_detail').trigger("chosen:updated");
		
		$('#modal-detail-project').modal({
			show: 'true'
		});
    } );
	
	$('#list-project tbody').on( 'click', '.update-project', function () {
        var data = tableProject.row( $(this).parents('tr') ).data();
		$("#code_update").val(data['code']);
		$("#name_update").val(data['name']);
		$("#project_owner_name_update").val(data['project_owner_name']);
		$("#project_owner_id_update").val(data['project_owner_id']);
		$("#customer_update").val(data['customer_id'] + "-" + data['customer_name']);
		$('#customer_update').trigger("chosen:updated");
		$("#id-project-update-form").val(data["id"]);
		if (data["is_completed"] == 1) {
			$('#is_completed_update').bootstrapSwitch('state', true);
		} else {
			$('#is_completed_update').bootstrapSwitch('state', false);
		}
		
		tinymce.get('description_update').setContent(decodeHtml(data['description']));
		
		$("#members_update option").prop('selected', false);
		if (data['members'].length > 0 ) {
			var objMembers = $.parseJSON(data['members']);
			$.each( objMembers, function( key, value ) {
				$("#members_update option[value='" + value.id + "-" + value.name + "']").prop('selected', true);
			});
		}	
		$('#members_update').trigger("chosen:updated");
		
		$('#modal-update-project').modal({
			show: 'true'
		});
    } );
	
	$('#list-project tbody').on( 'click', '.delete-project', function () {
        var data = tableProject.row( $(this).parents('tr') ).data();
		$("#code_project").html(data["code"]);
		$("#id_delete_form").val(data["id"]);
		$("#code_delete_form").val(data["email"]);
		$('#modal-delete-project').modal({
			show: 'true'
		});
    } );
	
	$('#bt-update-project-dialog').on("click", function(e) {
		$('#update-project-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallUpdateProjectDialog,
			onAjaxFormComplete: ajaxValidationCallbackUpdateProjectDialog
		});
		$('#bt-update-project-dialog').off('click');		
	});
	
	$('#bt-delete-project-dialog').on("click", function(e) {
		$('#delete-project-form').validationEngine({
			ajaxFormValidationMethod: 'post',
			ajaxFormValidation: true,
			onBeforeAjaxFormValidation : beforeCallDeleteProjectDialog,
			onAjaxFormComplete: ajaxValidationCallbackDeleteProjectDialog
		});
		$('#bt-delete-project-dialog').off('click');		
	});
});

function beforeCallDeleteProjectDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackDeleteProjectDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-delete-project').html(json.message);
		$('#error-delete-project').show();
		$('#success-delete-project').hide();
	} else if (json.result == 'success'){
		$('#success-delete-project').html(json.message);
		$('#success-delete-project').show();
		$('#error-delete-project').hide();
		window.location.href = base_url + "admin/projects";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallUpdateProjectDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdateProjectDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-project').html(json.message);
		$('#error-update-project').show();
		$('#success-update-project').hide();
	} else if (json.result == 'success'){
		$('#success-update-project').html(json.message);
		$('#success-update-project').show();
		$('#error-update-project').hide();
		window.location.href = base_url + "admin/projects";
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallAddProjectDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackAddProjectDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-add-project').html(json.message);
		$('#error-add-project').show();
		$('#success-add-project').hide();
		if (json.field == "code") {
			$("#code_insert").css("border", "1px solid red");
		}
	} else if (json.result == 'success'){
		$('#success-add-project').html(json.message);
		$('#success-add-project').show();
		$('#error-add-project').hide();
		$("#add-project-form input").css("border", "1px solid #ccc");
		window.location.href = base_url + "admin/projects";
	}
	
	$.LoadingOverlay("hide");
}

function decodeHtml(str) {
    return String(str).replace(/&amp/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}