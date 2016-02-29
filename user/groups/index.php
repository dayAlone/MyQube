<? 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Группы");
?>
<script>
$(document).ready(function(){
	
	$("#new-friends-number,.chat-head").click(function(){		
		$("#shadow-new-friens-popup").show();
		$("#shadow-friends-edit-popup").show();	
		var path = host_url+"/user/profile/ajax/friends.php";
		$.get(path, {}, function(data){
			$("#shadow-new-friens-popup").html(data);
		});
	});
	
	$("body").on("click", "#popup-friends-cancel", function(){
		$("#shadow-new-friens-popup").hide();
		$("#shadow-friends-edit-popup").hide();
	});
	
	$("body").on("click", ".add-or-del-friend", function(){
		var userID = $(this).data("id");
		var subin = $(this).data("subin");
		var path = host_url+"/user/profile/ajax/friends_res.php";
		var parent = $(this).parent();
		$.get(path, {userID:userID, subin:subin}, function(data){
			if($(parent).hasClass("popup_subs")) {
				$(parent).parent().remove();
			} else {
				$(parent).find('.del').hide();
				$(parent).find('.add').hide();
				$(parent).find('.'+data).show();
			}
		});
		if($(this).hasClass("add"))
			alert("Ваша заявка отправлена");
	});
	
	$(".id_add_photo").click(function(){
		$("#add_post_page").show();	
		$("#new_post_page").hide();
		$("#new_photo_page").show();
		$("#new_album_page").hide();
	});
});

function getName (str){
	var preview = document.getElementById('profile-avatar-img-popup');
	var file    = document.getElementById('upload_avatar').files[0];
	var reader  = new FileReader();
	reader.onloadend = function () {
		$("#profile-avatar-img-popup").css("background-image", "url('"+reader.result+"')");
	}
	if (file) {
		reader.readAsDataURL(file);
	} else {
		preview.src = "";
	}
}
function getName2 (obj, str){
	if (str.lastIndexOf('\\')){
		var i = str.lastIndexOf('\\')+1;
	}else{
	var i = str.lastIndexOf('/')+1;
	}						
	var filename = "("+str.slice(i)+")";			
	var uploaded = document.getElementById("fileformlabel");
	$(obj).parent().find(".selectbutton").html(filename+" <span></span>");
}
</script>	
<link rel="stylesheet" href="/css/cabinet.css">
<style>
	.frends-filter .slimScrollDiv {
		padding-top: 0 !important;
		margin: 0 !important;
	}
</style>
	<div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 101;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>
<div class="mobile-block mobile-menu-ico" id="menu-button"></div>
<?$APPLICATION->IncludeComponent("bitrix:menu", "top_line", Array(
		"ROOT_MENU_TYPE"	=>	"left",
		"MAX_LEVEL"	=>	"1",
		"CHILD_MENU_TYPE"	=>	"left",
		"USE_EXT"	=>	"Y",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "SECTION_ID",
			1 => "page",
		),
		"search" => "y"
		)
	);?>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/jquery.slimscroll.min.js"></script>
<link type="text/css" rel="stylesheet" href="/css/group.css">
<link rel="stylesheet" href="/css/profile-groups.css">
<script type="text/javascript" src="/js/web20/script.js"></script>
<style>
	.slimScrollDiv {
		margin:0 10%;
		padding-top:50px;
	}	
    
   @media screen and (max-device-width: 640px){
        .chat{
            display: none !important;
        }
        
        
        .users-number, .likes-number, .socblock{
            font-size: 22px;
        }
        
        .socblock{
            width: auto !important;
            margin-left: 10px;
        }
        
        .nomobile-span{
            display: none;
        }
        
        .slimScrollDiv{
            margin: 0 auto !important;
        }
       .slimScrollDiv{
            width: 100% !important;
       }
       
       .main-block{
            width: 100% !important;
       }
       
       .event{
            margin: 20px auto;
            float: none;
       }
       
        
        .item.search-preform{
            margin-left: 100px;
        }
        
        .mobile-menu-ico {
            z-index: 5;
            top: 14px;
            position: absolute;
            background: url(/images/menuicon.png );
            width: 40px;
            height: 40px;
            margin-left: 20px;
        }
        
        .event-header{
            width: 100% !important;
            font-size: 62px !important;
        }
        .event-date{
            background: none;
        }
        div.event-date{
            font-size: 30px !important;
        }
    } 
    .users-wrap {
			margin-left:0px !important;
	}
    .likes-wrap {
		width:60px !important;
	}
    
</style>
<script type="text/javascript">

            $("#menu-button").click(function(){
                
                if($("#nav_left_open").css('left') == '-165px'){
                    
                   $("#nav_left_open").animate({ left: '0' }, 400);
                    $("div.main").animate({ left: '165' }, 400);                   
                };
                if($("#nav_left_open").css('left') == '0px'){
          
                    $("#nav_left_open").animate({ left: '-165' }, 400);
                    $("div.main").animate({ left: '0' }, 400);
                };


                          
            })


	$(function(){
       
		$('#scroll_1').slimScroll({
			color: '#00d6ff',
			size: '10px',
			width: '850px',
			height: '100%',
			distance: '10px',
			alwaysVisible: true
		});
		$('.search-form input[name="q"]').keyup(function() { 
			$(".event").each(function(){
				if($('.search-form input[name="q"]').val()=='' || $(this).find(".event-header").html().toLowerCase().indexOf($('.search-form input[name="q"]').val().toLowerCase())>=0)
					$(this).show();
				else
					$(this).hide();
			});
		});
		/*$("a.likes").click(function(){
					$( this ).toggleClass( "active" );
					var path = host_url+"/user/groups/like_post.php";
					$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
					});
		});*/
	});
</script>
<div class="main-block" id="scroll_1">
	<div id="window_invite_group">
		<div class="header_invite">Для вступления в эту группу необходимо подать заявку</div>
		<div class="button_invite"><span>Введите ваш email.</span>
			<input type="text" style="padding: 5px 10px; width: 70%; margin: 10px 0 25px; text-align:center;" placeholder="E-mail">
			<button class="closed_group_button" style="padding: 5px 10px 5px 10px; background-color: #fff; color: #052b4b; font-size: 15px; text-transform: uppercase; border: none; font-weight: bold;">Отправить</button>
		</div>
	</div>
	<?
	$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
	CModule::IncludeModule("iblock");
	$arSelect = Array("ID", "IBLOCK_ID", "*");
	$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$arGroups[$arFields["ID"]] = $arFields;
		$arGroups[$arFields["ID"]]["PROPERTIES"] = $arProps;
		if($_GET["filter"] == "my-groups" && !in_array($arFields["ID"], $CurentUser["UF_GROUPS"]))
			break;
		?>
		<div class="event" id="event-<?=$arFields["ID"]?>" style="background-image: url('<?=CFile::GetPath($arProps["LIST_PICT_1"]["VALUE"])?>');">
			<div class="shadow-wrap">
			<div class="upper-card-block">
					<a href="/group/<?=$arFields["ID"]?>/"  <?=($arFields["ID"]==1)?"":"class='closed_group'";?>><div class="event-header">
					<?=$arFields["NAME"]?><span class="blue"></span>
						<hr>
					</div>
					<div class="event-date"><?=$arFields["PREVIEW_TEXT"]?></div></a>			
				</div>
			<div class="bottom-small-menu">
					<?$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arFields["ID"], "PROPERTY_USER" => $USER->GetID() ),array());?>
					<!--<div class="likes-wrap"><a class="likes <?=($res_like>0)?"active":""?>" id="like_group_<?=$arFields["ID"]?>"></a><div class="likes-number"><?=intval($arProps["LIKES"]["VALUE"])?></div></div>-->
					<?
						$GLOBALS['gl_active'] = $res_like;
						$GLOBALS['gl_like_id'] = "like_group_".$arFields["ID"];
						$GLOBALS['gl_like_numm'] = intval($arProps["LIKES"]["VALUE"]);
						$GLOBALS['gl_like_param'] = "post_id";
						$GLOBALS['gl_like_js'] = ($GLOBALS['gl_like_js']==1)?0:1;
						$GLOBALS['gl_like_url'] = "/user/groups/like_post.php";
						$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
							"AREA_FILE_SHOW" => "file", 
							"PATH" => "/like.php"
							)
						);
					?>
					<div class="users-wrap">
						<div class="users-icon" style="cursor:default;"></div>
						<div class="users-number"><? echo intval($arProps["USERS_M"]["VALUE"]); ?> <span class="nomobile-span"><?=getNumEnding(intval($arProps["USERS_M"]["VALUE"]), Array("участник", "участника", "участников"))?></span></div>
					</div>
					<div class="socwrap">
						<div class="social-buttons" style="cursor:default;"></div>
						<div class="socblock"><? echo intval($arProps["SHARES"]["VALUE"]); ?></div> <span style="top: 4px; position: relative; font-size: 11px;"><span class="nomobile-span">ПОДЕЛИЛИСЬ</span></span>
					</div>
				</div>
			</div>	
		</div>
		<?	
	}
	?>
</div>
<?/*$APPLICATION->IncludeComponent(
	"smsmedia:friends", 
	"myqube", 
	array(
		"SET_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "myqube",
		"USER_PROPERTY" => array(
			0 => "UF_PRIVATE_MYPAGE",
			1 => "UF_PRIVATE_MYFRIENDS"
		)
	),
	false
);*/
	/*echo "<xmp>";
	print_r($CurentUser["UF_FRIENDS"]);
	echo "</xmp>";*/?>
	<?
	$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/chat/index.php"
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>