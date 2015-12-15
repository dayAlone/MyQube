<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Календарь");
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
	
	$('.search-form input[name="q"]').keyup(function() { 
		$(".calendar-event").each(function(){
			if($('.search-form input[name="q"]').val()=='' || $(this).find(".calendar-event-name-main").html().toLowerCase().indexOf($('.search-form input[name="q"]').val().toLowerCase())>=0)
				$(this).show();
			else
				$(this).hide();
		});
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
<div class="shadow-profile-edit-popup" id="shadow-friends-edit-popup" style="display:none; z-index: 101;">
		<div id="shadow-new-friens-popup" class="shadow-new-friens-popup"></div>
	</div>
<style>
	div.main {
		padding-right: 210px;
	}
</style>
			<div class="center-menu" style="height:48px;width:100%;float:none;">
            
         <div class="mobile-block mobile-menu-ico" id="menu-button"></div>
        <style>
        
        @media screen and (max-device-width: 640px){
        .search-preform{
            margin-left: 60px;
        }
        
        .mobile-menu-ico{
            z-index: 3;
            position: absolute;
            background: url(/images/menuicon.png );
            width: 40px;
            height: 40px;
            margin-left: 20px;
            cursor: pointer;
        }
        
        .center-menu{
            height: 60px;
        }
        
        .profile-head{
            padding-top: 10px;
        }
        
        div.main{
            padding-right: 0px;
        }
        
        }
        </style>
        <script>
        
        $(function(){
                console.log("start");
            
                     $("#menu-button").click(function(){
                        console.log(1);
                        if($("#nav_left_open").css('left') == '-165px'){
                            console.log("right");
                           $("#nav_left_open").animate({ left: '0' }, 1200);
                            $("div.main").animate({ left: '165' }, 1200);                   
                        };
                        if($("#nav_left_open").css('left') == '0px'){
                  
                            $("#nav_left_open").animate({ left: '-165' }, 1200);
                            $("div.main").animate({ left: '0' }, 1200);
                        };
                    })
            
        })()
        </script>           
            
            
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
					"search" => "y",
					"search_pos" => "l"
					)
				);?>
			</div>
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
		);
?>
<link rel="stylesheet" href="/css/calendar.css">
<script>
	$(document).ready(function() {
		$(".calendar-week").click(function() {
			var numPeriod = $(this).data("period");
			$(".calendar-week").removeClass("selected-week");
			$("#link_period_num_"+numPeriod).addClass("selected-week");
			$(".body-period").hide();
			$("#body_period_num_"+numPeriod).show();
		});
	});
</script>
<?
	if(date("N", time()) == 1)
		$monday = date("j.n.Y", strtotime(date("j.n.Y", time())." Monday"));
	else
		$monday = date("j.n.Y", strtotime(date("j.n.Y", time())."  last Monday"));
	$start_date = $_GET["s"] ? $_GET["s"] : $monday;
	$end_date = $_GET["e"] ? $_GET["e"] : date("j.n.Y", strtotime(date("j.n.Y", time())."  next Sunday"));
	$nextWeek = date("j.n.Y", strtotime("1.".date("n.Y", strtotime($start_date))));
	
	$myID = CUser::GetID();
	CModule::IncludeModule("iblock");
	$arSelect = Array("ID", "IBLOCK_ID", "*");
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>2, "XML_ID"=>"FOR_USERS") );
	while($enum_fields = $property_enums->GetNext())
		$enums_id[] = $enum_fields["ID"];
	
	if(empty($_GET["filter"])) {
		if(date("U", strtotime($start_date)) < date("U", strtotime(date("j.n.Y", time()))))
			$start_date = date("j.n.Y", strtotime(date("j.n.Y", time())." Monday"));
		$arFilter = Array("IBLOCK_ID"=>2,
			array(
				"LOGIC"=>"OR", 
				array("IBLOCK_ID"=>2, "PROPERTY_ANC_ID"=>$myID)
			),
			array(
				"LOGIC"=>"AND", 
				array(">=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($start_date),'FULL')),"\'")),
				array("<=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($end_date),'FULL')),"\'"))
			)
		);
	} elseif(substr($_GET["filter"], 0, 4) == "next") {
		$arFilter = Array(
			"IBLOCK_ID"=>2,
			">=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($start_date),'FULL')),"\'"),
			"<=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($end_date),'FULL')),"\'")
		);
	} elseif(substr($_GET["filter"], 0, 4) == "prev") {
		$arFilter = Array(
			"IBLOCK_ID"=>2,
			//">=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($start_date),'FULL')),"\'"),
			"<=PROPERTY_START_DATE"=>trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($end_date),'FULL')),"\'")
		);
		if(!empty($_GET["s"]))
			$arFilter[">=PROPERTY_START_DATE"] = trim(CDatabase::CharToDateFunction(ConvertTimeStamp(strtotime($start_date),'FULL')),"\'");
	}
	if(!empty($_GET["place"]) && empty($_GET["s"])) {
		$arFilter = array();
		$arFilter["IBLOCK_ID"] = 2;
		$arFilter["PROPERTY_CITY"] = $_GET["place"];		
		if(empty($_GET["filter"]))
			$arFilter["PROPERTY_ANC_ID"] =$myID;
	}
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(Array("PROPERTY_START_DATE" => "DESC"), $arFilter, false, false, $arSelect);
	$numPeriod = 0;
	while($ob = $res->GetNextElement()) {
		$arFieldsC = $ob->GetFields();
		$arFieldsC["PROPS"] = $ob->GetProperties();	
		$place_events[] = $arFieldsC["PROPS"]["CITY"]["VALUE"];
		if(substr($_GET["filter"], 0, 4) == "prev" && $DB->CompareDates($arFieldsC["PROPS"]["START_DATE"]["VALUE"], date("d.m.Y", time())) == 1)
			continue;
		if(substr($_GET["filter"], 0, 4) == "next" && $DB->CompareDates($arFieldsC["PROPS"]["START_DATE"]["VALUE"], date("d.m.Y", time())) == -1)
			continue;
		
		if(substr($_GET["filter"], 0, 4) == "prev" && empty($stopDate)) {
			$stopDate = $arFieldsC["PROPS"]["START_DATE"]["VALUE"];
		}
		if(!empty($stopDate) && date("U", strtotime($stopDate."  last Monday")) > date("U", strtotime($arFieldsC["PROPS"]["START_DATE"]["VALUE"])))
			break;
		
		if(!empty($_GET["place"]) && empty($_GET["s"])) {
			$stopDate = $arFieldsC["PROPS"]["START_DATE"]["VALUE"];
		}
		if(!empty($stopDate) && date("U", strtotime($stopDate."  last Monday")) > date("U", strtotime($arFieldsC["PROPS"]["START_DATE"]["VALUE"])))
			break;
		
		if($notNew = $DB->CompareDates($arFieldsC["PROPS"]["START_DATE"]["VALUE"], $endPeriod) == 1)
			$numPeriod++;
		if(empty($thisPeriod) && $DB->CompareDates($arFieldsC["PROPS"]["START_DATE"]["VALUE"], date("d.m.Y", time())))
			$thisPeriod = $numPeriod;
		$endPeriod = $arFieldsC["PROPS"]["END_DATE"]["VALUE"];
		if($notNew)
			$startPeriod = $arFieldsC["PROPS"]["START_DATE"]["VALUE"];
		/*$periodName = "";
		if(FormatDate(array("d" => 'F'), MakeTimeStamp($startPeriod, "DD.MM.YYYY HH:MI:SS")) == FormatDate(array("d" => 'F'), MakeTimeStamp($endPeriod, "DD.MM.YYYY HH:MI:SS")))
			$periodName = $periodName.FormatDate(array("d" => 'j - '), MakeTimeStamp($startPeriod, "DD.MM.YYYY HH:MI:SS"));
		else
			$periodName = $periodName.FormatDate(array("d" => 'j F - '), MakeTimeStamp($startPeriod, "DD.MM.YYYY HH:MI:SS"));
		$periodName = $periodName.FormatDate(array("d" => 'j F'), MakeTimeStamp($endPeriod, "DD.MM.YYYY HH:MI:SS"));*/
		$periods[$numPeriod][] = array($periodName, $arFieldsC);
	}?>	
	
	<div class="calendar-block">
		<div class="calendar-menu-months">		
			<?
			for(substr($_GET["filter"], 0, 4) == "prev" ? $i = 5 : $i = 0; substr($_GET["filter"], 0, 4) == "prev" ? $i > -1 : $i > -6; $i--) {
				$thisMonth = "";
				//echo $stopDate;
				//if(!empty($stopDate) && empty($numMonth))
				//	$numMonth = date("n", strtotime($stopDate))-$i;
				//else
					$numMonth = date("n", time())-$i;				
				$numYear = $numMonth > 12 ? date("Y", time())+1 : date("Y", time());
				if($numYear !== date("Y", time())+1) $numYear = $numMonth < 1 ? date("Y", time())-1 : date("Y", time());
				$numMonth = $numMonth > 12 ? $numMonth-12 : $numMonth;
				if($numMonth !== 1) $numMonth = $numMonth < 1 ? 12+$numMonth : $numMonth;
				if(date("N", strtotime("1.".$numMonth.".".$numYear)) != 1)
					$s = date("j.n.Y", strtotime("1.".$numMonth.".".$numYear."  next Monday"));
				else
					$s = "1.".$numMonth.".".$numYear;				
				$e = date("j.n.Y", strtotime($s."  next Sunday"));
				$nameMonth = FormatDate(array("d" => 'f'), MakeTimeStamp($s, "DD.MM.YYYY HH:MI:SS"));
				$href = $APPLICATION->GetCurPageParam('s='.$s.'&e='.$e, array("s", "e"));
				if(date("n", strtotime($start_date)) == $numMonth)
					$thisMonth = ' selected-month';
				if(!empty($stopDate))
					$thisMonth = '';
				if(!empty($stopDate) && date("n", strtotime($stopDate)) == $numMonth)
					$thisMonth = ' selected-month';
				
				echo '<div class="calendar-month'.$thisMonth.'"><div><a href="'.$href.'">'.$nameMonth.'</a></div></div>';
			}
			?>
		</div>
	</div>
	<div class="calendar-menu-weeks">
		<style>
			.jq-selectbox {
				z-index: 1 !important;
			}
			.jq-selectbox li {
				background: #ebebeb !important;
				color: #898989 !important;
				padding: 6px 10px 0 !important;
				font-size: 13px !important;
			}
			.jq-selectbox ul {
				padding-bottom: 6px !important;
				background: #ebebeb !important;
			}
			.jq-selectbox__select {
			    position: relative;
				height: 22px !important;
				line-height: 24px !important;
				font-size: 13px !important;
				overflow: hidden !important;
				background: none !important;
				text-shadow: none !important;
				border: none !important;
				color: #fff !important;
				box-shadow:none !important;
				padding-right: 20px;
				width: 100px !important;
			}
			.opened {
				border: 1px solid #00d7ff !important;
			}
			.jq-selectbox__trigger {
				background: url(/images/select.png) no-repeat right;
				border: none !important;
				right: 5px !important;
			}
			.jq-selectbox__select-text {
				width: auto !important;
				font-family: GothamProRegular;
			}
			.jq-selectbox__trigger-arrow {
				border: none !important;
			}
			.jq-selectbox__dropdown {
				border: none !important;
				margin: 0 !important;
				width: 157px !important;
				left: -1px!important;
				font-family: GothamProRegular;
			}
		</style>
		<link href="/js/jQueryFormStyler/jquery.formstyler.css" rel="stylesheet" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/jQueryFormStyler/jquery.formstyler.min.js"></script>
<script>(function($) {
$(function() {

  $('.calendar-menu-weeks select').styler();

});
})(jQuery);</script>
		<div style="float:left; margin-right:50px;"><select onchange="top.location=this.value" style="">
			<option value="<?=$APPLICATION->GetCurPageParam("place=all", array("place", "s", "e"))?>"><span>Все города</span></option>
			<option value="<?=$APPLICATION->GetCurPageParam("place=Москва", array("place", "s", "e"))?>"<?if($_GET["place"] == "Москва") echo " selected";?>><span>Москва</span></option>
			<option value="<?=$APPLICATION->GetCurPageParam("place=Санкт-Петербург", array("place", "s", "e"))?>"<?if($_GET["place"] == "Санкт-Петербург") echo " selected";?>><span>Санкт-Петербург</span></option>
			<option value="<?=$APPLICATION->GetCurPageParam("place=Екатеринбург", array("place", "s", "e"))?>"<?if($_GET["place"] == "Екатеринбург") echo " selected";?>><span>Екатеринбург</span></option>
		</select></div>
		<?
		if(!empty($stopDate)) {
			$start_date = date("j.n.Y", strtotime($stopDate."  last Monday"));
			$end_date = date("j.n.Y", strtotime($stopDate."  next Sunday"));
		}
		$nextWeek = date("j.n.Y", strtotime("1.".date("n.Y", strtotime($start_date))));
		if(date("N", strtotime($nextWeek)) == 1) {
			$arWeek[] = $nextWeek = date("j.n.Y", strtotime("1.".date("n.Y", strtotime($start_date))));
		}
		while(date("n", strtotime($nextWeek)) == date("n", strtotime($start_date))) {
			$nextWeek = date("j.n.Y", strtotime($nextWeek."  next Monday"));
			$arWeek[] = $nextWeek;
		}
		foreach($arWeek as $key => $val) {
			$thisWeek = "";
			if(date("W", strtotime($start_date)) == date("W", strtotime($val)))
				$thisWeek = ' selected-week';
			$periodName = "";
			if(FormatDate(array("d" => 'F'), MakeTimeStamp($val, "DD.MM.YYYY HH:MI:SS")) == FormatDate(array("d" => 'F'), MakeTimeStamp($arWeek[$key+1], "DD.MM.YYYY HH:MI:SS")))
				$periodName = $periodName.FormatDate(array("d" => 'j-'), MakeTimeStamp($val, "DD.MM.YYYY HH:MI:SS"));
			else
				$periodName = $periodName.FormatDate(array("d" => 'j F - '), MakeTimeStamp($val, "DD.MM.YYYY HH:MI:SS"));
			$periodName = $periodName.FormatDate(array("d" => 'j F'), MakeTimeStamp(date("j.n.Y", strtotime($arWeek[$key+1]." - 1 hour")), "DD.MM.YYYY HH:MI:SS"));
			if($arWeek[$key+1])
				echo '<div class="calendar-week'.$thisWeek.'" id="link_period_num_"><a href="'.$APPLICATION->GetCurPageParam('s='.$val.'&e='.date("j.n.Y", strtotime($arWeek[$key+1]." - 1 hour")), array("s", "e")).'">'.$periodName.'</a></div>';
		}
		if(substr($_GET["filter"], 0, 4) == "prev")
			echo '<div class="calendar-week nextdate" style="float:left;margin-left:50px;" id="link_period_num_"><a href="'.$APPLICATION->GetCurPageParam('s='.date("j.n.Y", strtotime($start_date."  last Monday")).'&e='.date("j.n.Y", strtotime($end_date."  last Sunday")), array("s", "e")).'">Предыдущие даты</a></div>';
		if(substr($_GET["filter"], 0, 4) !== "prev")
			echo '<div class="calendar-week nextdate" style="float:left;margin-left:50px;" id="link_period_num_"><a href="'.$APPLICATION->GetCurPageParam('s='.date("j.n.Y", strtotime($start_date."  next Monday")).'&e='.date("j.n.Y", strtotime($end_date."  next Sunday")), array("s", "e")).'">Следующие даты</a></div>';
		?>
		<?/*foreach($periods as $keyP => $valP) {
			$last = array_pop($valP);?>
			<div class="calendar-week<?if($thisPeriod == $keyP) echo ' selected-week';?>" id="link_period_num_<?=$keyP?>" data-period="<?=$keyP?>"><?=$last[0]?></div>
		<?}*/?>
	</div>
	<?if(empty($periods)) echo '<div style="height: 95px;"></div>';?>
	<?foreach($periods as $keyP => $valP) {
		?>
		<div class="body-period" id="body_period_num_<?=$keyP?>" data-period="<?=$keyP?>"<?if($thisPeriod == $keyP) echo ' style="display: block;"';?>>
			<?foreach($valP as $keyEv => $valEv) {
				$arEv = $valEv[1];
				if(isset($_GET["place"]) && $arEv["PROPS"]["CITY"]["VALUE"] !== $_GET["place"] && "all" !== $_GET["place"]) continue;?>
				<div class="calendar-event" style="position:relative;" id="calendar-event-<?=$arEv["ID"]?>" onclick="window.location.href='/group/1/events/<?=$arEv["ID"]?>/'">
					<div class="calendar-event-photo" style="background-image: url('<?=CFile::GetPath($arEv["DETAIL_PICTURE"])?>')">
						<div class="calendar-event-photo-gradient"></div>
					</div>
					<div class="place-event" style="text-transform: uppercase;
    position: absolute;
    right: 5px;
    top: 5px; color:#00d7ff;"><?=$arEv["PROPS"]["CITY"]["VALUE"]?></div>
					<div class="calendar-event-data">
						<div class="calendar-event-data-week"><?=FormatDate(array("d" => 'l' ), strtotime($arEv["PROPS"]["START_DATE"]["VALUE"]))?></div>
						<div class="calendar-event-data-day"><?=FormatDate(array("d" => 'd' ), strtotime($arEv["PROPS"]["START_DATE"]["VALUE"]))?></div>
						<div class="calendar-event-data-month"><?=FormatDate(array("d" => 'F' ), strtotime($arEv["PROPS"]["START_DATE"]["VALUE"]))?></div>
					</div>
					<div class="calendar-event-name">
						<div class="calendar-event-name-head">
							at The Ushuaia Complex
						</div>
						<div class="calendar-event-name-main"><?=$arEv["NAME"]?></div>			
					</div>
				</div>
			<?}?>
		</div>
	<?}?>
<div class="calendar-shadow" style="    position: fixed;
    bottom: 0px;
    top: auto;
    width: 100%;"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>