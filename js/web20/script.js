$(document).ready(function(){
	$('body').on({
		mouseenter: function () {
			$(this).find(".socserv").fadeIn();
			$(this).find(".anons").slideDown('slow');
		},
		mouseleave: function () {
			$(this).find(".socserv").fadeOut();
			$(this).find(".anons").slideUp('slow');
		}
	}, ".block-hover");
	$(".background-container").click(function(){			
		containerClose();
	});
	$(".container .close").click(function(){			
		containerClose();
	});
});
function openPopup(file) {	
	$(".container").fadeOut();
	$(".manifest").fadeOut();
	$(".about_group").fadeOut();
	$(".konfidance").fadeOut();
	$(".container").fadeToggle();
	$("."+file).fadeToggle();
}
function containerClose() {			
	$(".container").fadeOut();
	$(".manifest").fadeOut();
	$(".about_group").fadeOut();
	$(".konfidance").fadeOut();
}
$(function(){
	$("a.closed_group" ).click(function(event) {
		event.preventDefault();
		$( "#window_invite_group" ).toggle();
	});
	$(".closed_group_button").click(function(event) {
		event.preventDefault();
		$( "#window_invite_group" ).toggle();
	});
});