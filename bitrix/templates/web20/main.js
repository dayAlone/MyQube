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
	
	$(".editing").click(function() {
	  $(this).next().toggle();
	});
	$(".editing_menu").click(function() {
	  $(this).toggle();
	});
	$(".editing_menu_delete_i").click(function(event) {
	  event.preventDefault();
	  var tmp = this;
	  $.ajax({
			url: host_url+"/delete/delete_el.php?id="+$(tmp).attr('id'),
			method: 'GET',
		}).done(function(data){
			$(tmp).closest(".photo_list_item").hide();
			$(tmp).closest(".video-block").hide();
			$(tmp).closest(".post").hide();
		});	
	});
})

var goBack_1 = function (h){
    var defaultLocation = host_url;
    var oldHash = window.location.hash;
	if(typeof(document.referrer) == "string" && document.referrer.indexOf("about")>1)
		history.back();
	else
	window.location.href = host_url+h;
	
	/*
    history.back();

    var newHash = window.location.hash;
    if(
        newHash === oldHash &&
        (typeof(document.referrer) !== "string" || document.referrer  === "")
    ){
        window.setTimeout(function(){
            // redirect to default location
            window.location.href = defaultLocation;
        },1000); // set timeout in ms
    }*/
    /*if(e){
        if(e.preventDefault)
            e.preventDefault();
        if(e.preventPropagation)
            e.preventPropagation();
    }*/
    return false; // stop event propagation and browser default event
}