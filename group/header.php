<?
if(empty($_GET["GROUP_ID"])) {
	LocalRedirect("/");
}
$Dir = explode("/",$_SERVER["REQUEST_URI"]);
if($_GET["back"] == "group")
	$numPage = $_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"];
if($_GET["page"])
	$numPage = $_GET["page"];
if($_GET["about"]==1)
	$_SESSION["BackFromDetail"]["brand"]=1;
else if($page_name=="lenta")
	$_SESSION["BackFromDetail"]["brand"]=0;
if($Dir[3]=="u_concept")
	$_SESSION["BackFromDetail"]["u_concept"]=1;
else if($page_name=="lenta")
	$_SESSION["BackFromDetail"]["u_concept"]=0;

CModule::IncludeModule("iblock");
$_GET["GROUP_ID"] = intval($_GET["GROUP_ID"]);
$res = CIBlockElement::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>4, "ID"=>$_GET["GROUP_ID"], "ACTIVE"=>"Y"), false, false, Array("ID", "IBLOCK_ID", "*"));
while($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
	$arGroup = $arFields;
	$arGroup["PROPERTIES"] = $arProps;
}	

$APPLICATION->SetPageProperty("title", $arGroup["NAME"]);
$APPLICATION->SetTitle($arGroup["NAME"]);
?>
<script>    
	$(window).load(function(){
		<?if($_GET["back"] == "group") {?>
			$(window).scrollTop(<?=$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"];?>);
		<?}?>
		$(".search-item-cover .fb_share_count").each(function(){ 
			if($(this).text()==""){
				var e=this;
				$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
					var res = JSON.parse(data);	
					$(e).text(res.sum);
				});
			}
		});
		$(".search-item .fb_share_count").each(function() { 
			if($(this).text()==""){
				var e=this;
				$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
					var res = JSON.parse(data);	
					$(e).text(res.sum);
				});
			}
		});   $("#popup-chechbox").change(function(){
    		$(".popup-text-reg-block").animate({left:"-100%"},1000);
    	});	

		<?if($page_name!=='explore'){?>
        if($("#menu-button").css("display")=="block") {
			$(".item").draggable();
			$("#menu-button").click(function(){
				if($("#nav_left_open").css('left') == '-165px'){
					$("#nav_left_open").animate({ left: '0' }, 600);
					$("div.main").animate({ left: '165' }, 600); 
					$("#nav_1").animate({ left: '165' }, 600);  
					if($("header").css('position')!="relative"){
						$("header").animate({ left: '165' }, 600);
					}  
				}
				if($("#nav_left_open").css('left') == '0px'){
					$("#nav_left_open").animate({ left: '-165' }, 600);
					$("div.main").animate({ left: '0' }, 600);
					$("#nav_1").animate({ left: '0' }, 600);
					if($("header").css('position')!="relative") {
						$("header").animate({ left: '0' }, 600);
					}
				}
			});
		}	
		<?};?>
		
	});
	$(document).ready(function(){
		var inProgress = false;
		var stop = false;
		var currentPage = <?=$numPage ? $numPage : 1?>;	
		var postsCounter = $("#block-wrapper").data("count");
		if(currentPage * 9 >= postsCounter)
			var stop = true;
		var filter = "?filter=<?=$_GET["filter"]?>";
		<?if(isset($_GET["about"]) && $_GET["about"] == 1) echo "filter = filter+\"&about=1\";";?>
		var path = host_url+"/group/<?=$page_name?>/ajax_<?=$page_name?>.php"+filter;
		$(window).scroll(function(){
			var scrollTop = $(this).scrollTop();
			if(scrollTop + $(window).height() >= $(document).height()-500 && !inProgress && !stop) {
				$.ajax({
					url: path+"&scroll="+scrollTop+"&count="+$('.search-item').length/9,
					method: 'GET',
					data: {PAGEN_1: ++currentPage, GROUP_ID: <?=$_GET["GROUP_ID"]?>},
					beforeSend: function() {inProgress = true;}
				}).done(function(data){
					$("#block-wrapper").append(data);
					inProgress = false;
					$(".search-item-cover .fb_share_count").each(function(){ 
						if($(this).text()==""){
							var e=this;
							$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
								var res = JSON.parse(data);	
								$(e).text(res.sum);
							});
						}
					});
					$(".search-item .fb_share_count").each(function() { 
						if($(this).text()==""){
							var e=this;
							$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
								var res = JSON.parse(data);	
								$(e).text(res.sum);
							});
						}
					});
				});						
				if(currentPage * 9 >= postsCounter)
					stop = true;
			}
			topsideHeight=270;
			bottomsideHeight=570;
			bottomPos=630;
			if($("#menu-button").css("display","block")){
				topsideHeight=140;
				bottomsideHeight =585;
				bottomPos=330;
			}
			<?if(isset($_GET["about"]) ){?>
				if(scrollTop < bottomsideHeight) {
					if(typeof $("#content_left_wrapper").attr("style") != "undefined"){
						$("#content_left_wrapper").removeAttr("style");
					}
				} else {
					$("#content_left_wrapper").css({"margin-top":scrollTop-bottomsideHeight});
				}
			<?} elseif($page_name=='lenta') {?>
				if(scrollTop >= topsideHeight){
					$("header").addClass("fixed");
					$("#content_left_wrapper").addClass("thin");
					$("#content_left").addClass("thin");
					$("header").css('background-image', "url('<?=($_GET["v"]==1)?"/images/shapka_2_small.png":CFile::GetPath($arGroup["PROPERTIES"]["THIN_PICT"]["VALUE"])?>')");
					$("#nav_1").addClass("fixed");
					$("#content_container").css({"margin-top":bottomPos+"px"});
				} else if(scrollTop<=topsideHeight-12 ) {
					$("header").removeClass("fixed");
					$("#content_left_wrapper").removeClass("thin");
					$("#content_left").removeClass("thin");
					$("header").css('background-image', "url('<?=($_GET["v"]==1)?"/images/shapka_2_big.png":CFile::GetPath($arGroup["PREVIEW_PICTURE"])?>')");
					$("#nav_1").removeClass("fixed");
					$("#content_container").css({"margin-top":"28px"});
				}
			<?}?>		
			var contentInner = $("#content_inner").height()+45;
			var isMob = 0;
			var scrollLeft = $(window).scrollLeft();
			scrollFirst = -285;
			scrollSecond = 162;
			if($("#menu-button").css("display")=="block"){
				scrollFirst = -330;
				scrollSecond = 170;
			}
			var xScroll = scrollTop + <?if($page_name=="lenta"){?>scrollFirst<?}else{?>scrollSecond<?}?>;
			if(contentInner > xScroll+255)
				$("#content_left").css("top",xScroll+"px");   
			var yScroll = - scrollLeft;
			$(".full_h.fixed").css("background-position",yScroll+"px");
			var yScrollMenu = - scrollLeft + isMob;
			var yScrollMenuPadding = scrollLeft+75; 
		});
		$("#enter_page_form").submit(function(){
			$(".error").hide();
			var submit = true;				
			$(this).find('.requried').each(function(){
				if($(this).attr("type") == "checkbox"){
					if(!$(this).prop("checked")){
						submit = false;
						$(this).next("label").css("color", "red");
						var id = $(this).attr("id");
						$("."+id).css({"display":"block"});
						$("#return_main_page").show();
					}
				} else {
					if($(this).val() == ''){
						submit = false;
						var id = $(this).attr("id");
						if(id)
							$("."+id).css({"display":"block"});
						else
							$(".birthday").css({"display":"block"});
						$("#return_main_page").show();
					}
				}
			});
			return submit;
		});
	});
	$("body").on("mouseenter", ".lenta_item", function() {
		var id_p=$(this).attr('id');
		$(this).children( '#'+id_p ).fadeTo(300,0);
		$(".cover_bottom_info").hide();
		$("#bottom_"+id_p).show();
		$("#bottom_"+id_p).animate({ bottom: '0' }, 1200);
	});
	$("body").on("mouseleave", ".lenta_item", function() {
		var id_p=$(this).attr('id');
		$(this).children( '#'+id_p ).fadeTo(300,0.3);
		$("#bottom_"+id_p).show();
		$("#bottom_"+id_p).animate({ bottom: '-255px' }, 1200);
	});
    
	$("div.likes").click(function(){
		$( this ).toggleClass( "active" );
		var path = host_url+"/group/lenta/like_post.php";
		$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){});
	});
	$(".show_popup").click(function(){
		$("#show_popup").fadeIn();
		$(".dark-background").fadeIn();
	});
	$(document).mouseup(function (e){
		var div = $("#show_popup");
		var close = $(".close_popup");
		if ((!div.is(e.target) && div.has(e.target).length === 0) || close.is(e.target)) {
			div.fadeOut();				
			$(".dark-background").fadeOut();
		}
	});
	//$('.privacy-text').slimScroll({ color: '#00d6ff', size: '10px', width: '630px', height: '430px', distance: '10px', alwaysVisible: true });		
	$('.search-form input[name="q"]').keyup(function() { 
		$(".search-item").each(function(){
			if($('.search-form input[name="q"]').val()=='' || $(this).find(".search-item-name").html().toLowerCase().indexOf($('.search-form input[name="q"]').val().toLowerCase())>=0) {
				$(this).css({"display":"<?if($page_name=="video")echo "inline-block"; else "table"?>"});
			} else {
				$(this).css({"display":"none"});
			}
		});
	});
</script>
<?
if((!$USER->IsAuthorized() || $_GET["message"] == "birthday" || $_GET["message"] == "checking_user_fields" || $_GET["message"] == "you_are_under_18") && empty($_GET["POST_ID"])) {
	include("page_auth.php");
} elseif($USER->IsAuthorized()) {
	$_SESSION["MQ_GROUP_LAST_POINT"] = $APPLICATION->GetCurPageParam("back=group", array("back"));
	if($page_name=="lenta_detail") {
		include("lenta/dop_detail.php");
	} else {
		include("page_groups.php");
	}
} elseif($_GET["POST_ID"]) {
	include("page_tiser.php");
}?>