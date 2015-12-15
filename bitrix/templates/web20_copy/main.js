function preload(arrayOfImages) {
	$(arrayOfImages).each(function(){
		$('<img/>')[0].src = this;
		// Alternatively you could use:
		// (new Image()).src = this;
	});
}

var host_url = "http://"+window.location.hostname;
var template_url = "http://"+window.location.hostname+"/bitrix/templates/web20";
$(function(){
	// Usage:
	
	preload([
		template_url+"/images/messages_hover.png",
		template_url+"/images/news_hover.png",
		template_url+"/images/groups_hover.png",
		template_url+"/images/personal_hover.png",
		template_url+"/images/contests_hover.png",
		template_url+"/images/calendar_hover.png",
		template_url+"/images/news_hover.png",
		template_url+"/images/q_logo_full.png",
		template_url+"/images/back-menu_hover.png",
		host_url+"/upload/iblock/145/4.jpg"
	]);
})