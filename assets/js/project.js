$(document).ready(function(){
	$('.dialog-edit').on("click", function(e){
		e.stopPropagation();
		$('.edit-box-project').css({'top':e.pageY+10,'left':e.pageX - 50});
		if ($(".edit-box-project").is(":visible") == false) {
			$(".box").hide();
		}
		$('.edit-box-project').toggle();
	});
	
	$('.user-assignee-list').chosen({width: "170px", allow_single_deselect: true}).change(function(e){
		var  target = $(e.target);
		currentDataSet = target.val();
		$.LoadingOverlay("show");
		var dataTaskString = $(".edit-box-assignee").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		$.ajax({
			url : base_url + "project/updateAssignee",
			type : "post",
			dateType:"json",
			data : {
				taskId : taskId,
				userAssignee : currentDataSet
			},
			success : function (result){
				$.LoadingOverlay("hide");console.log(base_url + "project/" + projectArr["id"] + "/" + taskId);
				location.reload();
			}
		});
	});
	
	$(".button-assignee-to-me").on("click", function(e) {
		e.preventDefault();
		var dataTaskString = $(".edit-box-assignee").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		
		var dataUserLoggedString = $(".edit-box-assignee").attr("data-user-logged");
		var dataUserLogged = $.parseJSON(dataUserLoggedString);
		
		var userAssignee = dataUserLogged["id"] + "-" + dataUserLogged["name"];
		$.LoadingOverlay("show");
		$.ajax({
			url : base_url + "project/updateAssignee",
			type : "post",
			dateType:"json",
			data : {
				taskId : taskId,
				userAssignee : userAssignee
			},
			success : function (result){
				$.LoadingOverlay("hide");
				//$('.edit-box-assignee').toggle();
				//$(".user-assignee-list").val("").trigger("chosen:updated");
				location.reload();
			}
		});
	});
	
	$(".mark-complete-border").on("click", function(e) {
		e.preventDefault();
		var dataTaskString = $(this).parent().parent().attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		$.LoadingOverlay("show");
		$.ajax({
			url : base_url + "project/updateCompleted",
			type : "post",
			dateType:"json",
			data : {
				taskId : taskId
			},
			success : function (result){
				$.LoadingOverlay("hide");
				//$('.edit-box-assignee').toggle();
				//$(".user-assignee-list").val("").trigger("chosen:updated");
				location.reload();
			}
		});
	});
	
	$('.border-icon-not-assignee').on("click", function(e){
		e.stopPropagation();
		var dataTaskString = $(this).parent().parent().attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		
		var dataUserLoggedString = $(this).parent().parent().attr("data-user-logged");
		var dataUserLogged = $.parseJSON(dataUserLoggedString);
		
		var assignee = dataTask["user_assignee_id"] + "-" + dataTask["user_assignee_name"];
		
		if (dataTask["user_assignee_id"] == dataUserLogged["id"]) {
			$(".button-assignee-to-me-container").hide();
			$(".button-assignee-to-me-container").prev().hide();
		} else {
			$(".button-assignee-to-me-container").show();
			$(".button-assignee-to-me-container").prev().show();
		}
		var width = $('.edit-box-assignee').width();
		$('.edit-box-assignee').css({'top':$(this).offset().top + 35,'left': $(this).offset().left - width + 20});
		
		$('.edit-box-assignee').attr("data-task", dataTaskString);
		$(".user-assignee-list").val(assignee).trigger("chosen:updated");
		if ($(".edit-box-assignee").is(":visible") == false) {
			$(".box").hide();
		}
		$('.edit-box-assignee').toggle();
	});
	
	$(".icon-assigned-container").on("click", function(e) {
		e.stopPropagation();
		var dataTaskString = $(this).parent().parent().attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		
		var dataUserLoggedString = $(this).parent().parent().attr("data-user-logged");
		var dataUserLogged = $.parseJSON(dataUserLoggedString);
		
		var assignee = dataTask["user_assignee_id"] + "-" + dataTask["user_assignee_name"];
		
		if (dataTask["user_assignee_id"] == dataUserLogged["id"]) {
			$(".button-assignee-to-me-container").hide();
			$(".button-assignee-to-me-container").prev().hide();
		} else {
			$(".button-assignee-to-me-container").show();
			$(".button-assignee-to-me-container").prev().show();
		}
		
		var width = $('.edit-box-assignee').width();
		$('.edit-box-assignee').css({'top':$(this).offset().top + 35,'left': $(this).offset().left - width + 20});
		$(".user-assignee-list").val(assignee).trigger("chosen:updated");
		$('.edit-box-assignee').attr("data-task", dataTaskString);
		if ($(".edit-box-assignee").is(":visible") == false) {
			$(".box").hide();
		}
		$('.edit-box-assignee').toggle();
	});
	
	$('.edit-box-assignee').on('click', function(e){
		e.stopPropagation();
	});
	
	$("#update-project-menu").on("click", function(e){
		e.preventDefault();
		var data = projectArr;
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
		
		tinymce.get('description_update').setContent(data['description']);
		$('#modal-update-project').modal({
			show: 'true'
		});
	});
	
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
	
	$("#delete-project-menu").on("click", function(e){
		e.preventDefault();
		var data = projectArr;
		$("#name_project").html(data["name"]);
		$("#id_delete_form").val(data["id"]);
		$("#code_delete_form").val(data["email"]);
		$('#modal-delete-project').modal({
			show: 'true'
		});
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
	
	$(".content-left").height($(".inner").height());
	
	$(".content-right").height($(".inner").height());
	
	$(".task-name").on("click", function(e){
		var dataTaskString = $(this).parent().parent().attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		$(".content-right").attr("data-task", dataTaskString);
		if (parseInt(dataTask["user_assignee_id"]) > 0) {
			$(".detail-task-border-assignee").hide();
			$(".detail-task-border-assigned").show();
		} else {
			$(".detail-task-border-assigned").hide();
			$(".detail-task-border-assignee").show();
		}
		var shortName = $(this).parent().next().find(".icon-assigned-container").html();
		$(".detail-task-border-assigned-button").html(shortName);
		$(".detail-task-border-assigned span").html(dataTask["user_assignee_name"]);
		
		if (parseInt(dataTask["estimate_hours"]) > 0) {
			$(".not-set-due-date-border").hide();
			$(".set-due-date-border").show();
		} else {
			$(".set-due-date-border").hide();
			$(".not-set-due-date-border").show();			
		}
		
		if (dataTask["estimate_hours"] > 0 ) {
			var dueDateTimeStamp = parseInt(dataTask["created"]) + (dataTask["estimate_hours"] * 3600);
			var dueDate = new Date(dueDateTimeStamp * 1000);
			$(".set-due-date-border .set-value-due-date").html(formatDueDate(dueDate));
		}
		$(".list-task tr").removeClass("active");
		$(this).parent().parent().addClass("active");
		
		$(".name-task textarea").html(dataTask["name"]);
		$(".content-left").animate({
			width: "49%"
		},500);
		$(".content-right").animate({
			width: "49%"
		},500).show();
	});
	
	$(".button-close-content-right").on("click", function(e) {
		e.preventDefault();
		$(".content-left").animate({
			width: "100%"
		},500);
		$(".content-right").animate(500).hide();
	});
	
	$("#assignee_insert").chosen({width: "100%"});
	
	$(".button-add-task").on("click", function(e) {
		e.preventDefault();
		$('#modal-add-new-task').modal({
			show: 'true'
		});
	});
	
	$('#bt-add-task-dialog').on("click", function(e) {
		$('#add-task-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallAddTaskDialog,
			onAjaxFormComplete: ajaxValidationCallbackAddTaskDialog
		});
		$('#bt-add-task-dialog').off('click');
	});
	
	$('.edit-right-box-assignee').on("click", function(e){
		e.stopPropagation();
	});
	
	$(".select-user-assignee-right").chosen({width: "200px", allow_single_deselect: true}).change(function(e){
		var  target = $(e.target);
		currentDataSet = target.val();		
		$.LoadingOverlay("show");
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		$.ajax({
			url : base_url + "project/updateAssignee",
			type : "post",
			dateType:"json",
			data : {
				taskId : taskId,
				userAssignee : currentDataSet
			},
			success : function (result){
				$.LoadingOverlay("hide");
				window.location.href = base_url + "project/" + projectArr["id"] + "/" + taskId;
			}
		});
	});
	
	$('.task-assignee-right').on("click", function(e) {
		e.preventDefault();
		e.stopPropagation();
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var assignee = dataTask["user_assignee_id"] + "-" + dataTask["user_assignee_name"];
		var width = $('.edit-right-box-assignee').width();
		$('.edit-right-box-assignee').css({'top':$(this).offset().top + 34,'left': $(this).offset().left - 5});
		$(".select-user-assignee-right").val(assignee).trigger("chosen:updated");
		if ($(".edit-right-box-assignee").is(":visible") == false) {
			$(".box").hide();
		}
		$('.edit-right-box-assignee').toggle();
	});
	
	$(".remove-assignee-button").on("click", function(e){
		e.preventDefault();
		e.stopPropagation();
		$(".select-user-assignee-right").val("").trigger("change");
	});
	
	if (taskId.length > 0) {
		$(".task-name[id-task='" + taskId + "']").trigger("click");
	}
	
	$(".due-date-right").on("click", function(e){
		e.stopPropagation();
		var width = $('.edit-due-date-box').width();
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		
		$('.edit-due-date-box').css({'top':$(this).offset().top + 34,'left': $(this).offset().left + 10});
		if ($(".edit-due-date-box").is(":visible") == false) {
			$(".box").hide();
			$(".edit-due-date-box .alert").hide();
		}
		$("#estimate_hours").val(dataTask["estimate_hours"]);
		$(".edit-due-date-box #task_id").val(dataTask["id"]);
		$(".edit-due-date-box").toggle();
	});
	
	$("#bt-update-estimate-hours").on("click", function(e) {
		e.stopPropagation();
		$('#update-estimate-hours-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallUpdateEstimateHoursDialog,
			onAjaxFormComplete: ajaxValidationCallbackUpdateEstimateHoursDialog,
			scroll: false
		});
		$('#bt-update-estimate-hours').off('click');	
	});
	
	$('.edit-due-date-box').on("click", function(e){
		e.stopPropagation();
	});
	
	$(".remove-due-date").on("click", function(e) {
		e.preventDefault();
		e.stopPropagation();
		$.LoadingOverlay("show");
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		$.ajax({
			url : base_url + "project/updateEstimateHours",
			type : "post",
			dateType:"json",
			data : {
				task_id : taskId,
				estimate_hours : 0
			},
			success : function (result){
				$.LoadingOverlay("hide");
				location.reload();
			}
		});
	});
	
	$(".edit-task-right").on("click", function(e) {
		e.stopPropagation();
		var width = $('.edit-box-task').width();
		$('.edit-box-task').css({'top':$(this).offset().top + 36,'left': $(this).offset().left - width + 37});
		if ($(".edit-box-task").is(":visible") == false) {
			$(".box").hide();
		}
		$('.edit-box-task').toggle();
	});
	
	$(".delete-task-menu").on("click", function(e) {
		e.stopPropagation();
	});
	
	$("#delete-task-menu").on("click", function(e){
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		$("#id_task_delete_form").val(dataTask["id"]);
		$("#task_name").html(dataTask["name"]);
		$('#modal-delete-task').modal({
			show: 'true'
		});
	});
	
	$("#bt-delete-task-dialog").on("click", function(e) {
		$('#delete-task-form').validationEngine('attach',{
			ajaxFormValidation: true,
			maxErrorsPerField:1,
			ajaxFormValidationMethod: 'post',
			onBeforeAjaxFormValidation : beforeCallDeleteTaskDialog,
			onAjaxFormComplete: ajaxValidationCallbackDeleteTaskDialog
		});
		$('#bt-delete-task-dialog').off('click');
	});
	
	$("textarea").each(function () {
		var timer = null;
		$(this).change(function(){
			var node = this;
			if(timer != null)
				clearTimeout(timer);

			timer = setTimeout(function(){
				 $(node).trigger('lastchange');
			}, 100);
		});
	});

	$("textarea.value-name-task").bind("lastchange", function (e) {
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var nameTask = $(this).val();
		$.ajax({
			url : base_url + "project/updateTitleTask",
			type : "post",
			dateType:"json",
			data : {
				taskId : dataTask["id"],
				nameTask : nameTask
			},
			success : function (result){
			}
		});
	});
	
	$(".mark-complete-border-right").on("click", function(e) {
		e.preventDefault();
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		var taskId = dataTask["id"];
		$.LoadingOverlay("show");
		$.ajax({
			url : base_url + "project/updateCompleted",
			type : "post",
			dateType:"json",
			data : {
				taskId : taskId
			},
			success : function (result){
				$.LoadingOverlay("hide");
				location.reload();
			}
		});
	});
});

$(document).click(function() {
	$(".box").hide();
});

function formatDueDate(dueDate) {
	dueDate.setHours(dueDate.getHours() + Math.round(dueDate.getMinutes()/60));
	dueDate.setMinutes(0);
	dueDate.setSeconds(0);
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov","Dec"];
	var month = monthNames[dueDate.getMonth()];
	var day = ("0" + dueDate.getDate()).slice(-2);
	var year = dueDate.getFullYear();
	var hours = dueDate.getHours();
	hours = (hours + 24 -2 ) % 24; 
	var mid='am';
	if (hours == 0) {
		hours = 12;
	} else if( hours > 12) {
		hours = hours % 12;
		mid='pm';
	}
	return  month + " " + day + ", " + year + " " + hours + ":00" + mid;
}

function beforeCallDeleteTaskDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackDeleteTaskDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-delete-task').html(json.message);
		$('#error-delete-task').show();
		$('#success-delete-task').hide();
	} else if (json.result == 'success'){
		$('#success-delete-task').html(json.message);
		$('#success-delete-task').show();
		$('#error-delete-task').hide();
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		window.location.href = base_url + "project/" + projectArr["id"];
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallUpdateEstimateHoursDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackUpdateEstimateHoursDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-update-estimate-hours').html(json.message);
		$('#error-update-estimate-hours').show();
		$('#success-update-estimate-hours').hide();
	} else if (json.result == 'success'){
		$('#success-update-estimate-hours').html(json.message);
		$('#success-update-estimate-hours').show();
		$('#error-update-estimate-hours').hide();
		var dataTaskString = $(".content-right").attr("data-task");
		var dataTask = $.parseJSON(dataTaskString);
		window.location.href = base_url + "project/" + projectArr["id"] + "/" + dataTask["id"];
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallAddProjectDialog(form, options){				
	$.LoadingOverlay("show");
	return true;
}

function ajaxValidationCallbackAddTaskDialog(status, form, json, options){
	if (json.result == 'error') {
		$('#error-add-task').html(json.message);
		$('#error-add-task').show();
		$('#success-add-task').hide();
	} else if (json.result == 'success'){
		$('#success-add-task').html(json.message);
		$('#success-add-task').show();
		$('#error-add-protaskject').hide();
		location.reload();
	}
	
	$.LoadingOverlay("hide");
}

function beforeCallAddTaskDialog(form, options){				
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
		if (role == "admin") {
			window.location.href = base_url + "admin/projects";
		} else {
			window.location.href = base_url + "user/projects";
		}
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
		location.reload();
	}
	
	$.LoadingOverlay("hide");
}