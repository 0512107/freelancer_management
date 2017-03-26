$(document).ready( function() {
	$("#menu li a").hover(
		function() {
			if (!$(this).parent().hasClass("active")) {
				$(this).find("i").addClass("fa-spin");
			}
		},
		function() {
			if (!$(this).parent().hasClass("active")) {
				$(this).find("i").removeClass("fa-spin");
			}
		}
	);
});