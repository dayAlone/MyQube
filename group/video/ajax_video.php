<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_GET["scroll"])
	$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"] = $_GET["scroll"];
if($_GET["count"])
	$_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"] = $_GET["count"];
?>
<link rel="stylesheet" href="/css/video.css"><?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 8;
	$arPosts = array();
	
	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_GET["page"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $nPageSize*9;
	else
		$nPageSizePhoto = 9;
	
	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "PROPERTY_ANC_ID" => $group_id, "PROPERTY_ANC_TYPE" => 20);
	if(isset($only_my)&&$only_my==1) {
		$arFilter['PROPERTY_ANC_ID']=$only_for;
		$arFilter['PROPERTY_ANC_TYPE']=19;
	}
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(array("ID" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	foreach($arPosts as $arPost)
	{
		if($elementNum == 9) {
			++$page;
			$elementNum = 0;
		}
		++$elementNum;
		$link = $arPost["ID"].'/?page='.$page;;
		$user = CUser::GetByID($arPost["CREATED_BY"])->Fetch();
		if(empty($arPost["PREVIEW_PICTURE"])) {
			$parsed_url = parse_url($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
			parse_str($parsed_url['query'], $parsed_query);
			if(strpos($arPost["PROPERTIES"]["VIDEO"]["VALUE"],"vimeo.com"))
			{
				$vimeo_video_id = intval(preg_replace('/^.*vimeo.com\/(\d+)$/i','$1',$arPost["PROPERTIES"]["VIDEO"]["VALUE"]));
				if(!($vimeo_video_id>0))
					$vimeo_video_id = fetch_vimeo_id($arPost["PROPERTIES"]["VIDEO"]["VALUE"]);
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vimeo_video_id.php"));
				$pic=$hash[0]['thumbnail_large']; 
			}
			else
				$pic = "http://img.youtube.com/vi/".$parsed_query['v']."/0.jpg";
		} else {
			$pic = CFile::GetPath($arPost["PREVIEW_PICTURE"]);
		}
		?>
		<div class="video-block search-item" id="video-<?=$arPost["ID"]?>">
			<?if($USER->IsAdmin()||$arPost["CREATED_BY"]==$USER->GetID()){?>
					<a class="editing" title="редактировать">•••</a>
					<div class="editing_menu">
						<div class="editing_menu_delete"><a href="#" class="editing_menu_delete_i" id="<?=$arPost["ID"]?>">Удалить</a></div>
						<div class="editing_menu_cancel">Отмена</div>
					</div>
			<?}?>
			<a href="<?=$link?>"><div class="video-img" style="background: url('<?=$pic?>'); background-size: cover;">
				<div class="play-img"></div>
                <div class="video-block-header mobile-block search-item-name"><?=$arPost["NAME"]?></div>
			</div></a>
			<div class="video-name"><a href="<?=$link?>"><?=$arPost["NAME"]?></a></div>
			<style>
				.video-socbutton .likes, .video-socbutton .comments-icon, .video-socbutton .social-buttons{
					cursor: default;
				}
			</style>
			<div class="video-socbutton" style="margin: 30px 0 0 20px;">
				<!-- класс video-like-gray - серый video-like-red - красный лайк -->
				<?
						$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
				?>
				<!--<a class="likes <?=($res_like>0)?"active":""?>" id="like_post_<?=$arPost["ID"]?>"></a>-->
				<?
				/*$GLOBALS['gl_active'] = $res_like;
				$GLOBALS['gl_like_id'] = "like_post_".$arPost["ID"];
				$GLOBALS['gl_like_numm'] = intval($arPost["PROPERTIES"]["LIKES"]["VALUE"]);
				$GLOBALS['gl_like_param'] = "post_id";
				$GLOBALS['gl_like_js'] = (!isset($GLOBALS['gl_like_js']))?1:0;
				$GLOBALS['gl_like_url'] = "/group/video/like_post.php";
				$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"PATH" => "/like.php"
					)
				);*/
				?>
				<div class="likes-wrap" style="float:left;">
					<a id="like_post_1279" class="likes_tiser" style="margin-right:5px;"></a>
					<div class="likes-number" style="padding-top:4px;margin-left:25px;"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></div>
				</div>
				<a class="comments-wrap">
							<div class="comments-icon"></div>
							<div class="comments-number"><?=intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> <?=getNumEnding(intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"]), Array("комментарий", "комментария", "комментариев"))?></div>
				</a>
				<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
				<div class="socwrap">
					<!-- Кнопка репоста -->
					<div class="social-buttons"></div>
					 <span link="<?=urlencode("http://".SITE_SERVER_NAME."/group/1/video/".$arPost["ID"].'/')?>" class= "fb_share_count" style="vertical-align: baseline; color:#fff; text-align:center; padding-top: 4px;"></span>
				</div>
				<?}?>
			</div>
		</div>
		<?		
	}
	?>