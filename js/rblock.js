$(window).scroll(function () {   
    var xScroll = $(window).scrollTop() + 162/*- 285*/;
    $("#content_left").css("top",xScroll+"px");   
    var yScroll = - $(window).scrollLeft();
    $(".full_h.fixed").css("background-position",yScroll+"px");
    var yScrollMenu = - $(window).scrollLeft()+25;
    var yScrollMenuPadding = $(window).scrollLeft()+75; 

 //   if ($("#nav_1").css("padding-right").slice(0, -2) < 240 && $(window).scrollTop() > 350 ){console.log($("#nav_1").css("padding-right"));$("#nav_1").css("padding-right",yScrollMenuPadding+"px");  }   
      
    $("#nav_1").css("left",yScrollMenu+"px");     
});