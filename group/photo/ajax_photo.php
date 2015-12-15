<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_GET["scroll"])
	$_SESSION["MQ_GROUP_LAST_POINT_SCROLL"] = $_GET["scroll"];
if($_GET["count"])
	$_SESSION["MQ_GROUP_LAST_POINT_COUNT_POSTS"] = $_GET["count"];
?><?
	CModule::IncludeModule("iblock");
	$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
	$iblock_id = 7;
	$arPosts = array();
	
	// Постраничная пагинация / Сессия прописывается в init.php
	if(($nPageSize = $_GET["page"]) && !$_GET["PAGEN_1"])
		$nPageSizePhoto = $nPageSize*9;
	else
		$nPageSizePhoto = 9;
	$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "PROPERTY_ANC_ID" => $group_id, "PROPERTY_ANC_TYPE" => 18);
	if(isset($only_my)&&$only_my==1) {
		$arFilter['PROPERTY_ANC_ID']=$only_for;
		$arFilter['PROPERTY_ANC_TYPE']=17;
	}
	/*if($_GET["events"] == "archiv")
		$arFilter["<=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";
	else
		$arFilter[">=PROPERTY_DATE_EVENT"] = ConvertDateTime(date("d.m.Y", time()), "YYYY-MM-DD")." 00:00:00";*/
	
	if($_GET["q"])
		$arFilter["%NAME"] = $_GET["q"];
	$res = CIBlockElement::GetList(array("active_from" => "DESC"), $arFilter, false, Array("nPageSize" => $nPageSizePhoto));
	while($arItemObj = $res->GetNextElement(true, false)){
		$arItem = $arItemObj->GetFields();
		$arItem["PROPERTIES"] = $arItemObj->GetProperties();
		$arPosts[$arItem["ID"]] = $arItem;
	}
	$page = $res->NavPageNomer;
	$elementNum = 0;
	?>
	<div class="photo_list">
		<?
		foreach($arPosts as $arPost)
		{
			//echo "<xmp>";print_r($arPost);echo "</xmp>";
			if($elementNum == 9) {
				++$page;
				$elementNum = 0;
			}
			++$elementNum;
			$link = $arPost["ID"].'/?page='.$page;
			$user = CUser::GetByID($arPost["CREATED_BY"])->Fetch();
			$file = CFile::ResizeImageGet($arPost["PREVIEW_PICTURE"], array('width'=>280, 'height'=>300), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<div class="photo_list_item search-item" id="photo_list_item_<?=$arPost["ID"]?>" style="background: url('<?=$file["src"]?>');">
				<img class="photo_list_gradient" src="<?=SITE_TEMPLATE_PATH?>/images/gradient.png">
				<a href="<?=$link?>" style="position: absolute; width: 280px; height: 250px;"></a>
				<?if($USER->IsAdmin()||$arPost["CREATED_BY"]==$USER->GetID()){?>
					<a class="editing" title="редактировать">•••</a>
					<div class="editing_menu">
						<div class="editing_menu_delete"><a href="#" class="editing_menu_delete_i" id="<?=$arPost["ID"]?>">Удалить</a></div>
						<div class="editing_menu_cancel">Отмена</div>
					</div>
				<?}?>
				<div class="photo_list_user">
					<!--div class="photo_list_avatar" style="background: url('<?=CFile::GetPath($user["PERSONAL_PHOTO"])?>'); background-size: 80px;">
					</div>
					<div class="photo_list_name"><?=$user["NAME"]?></div-->
					<div class="photo_list_header search-item-name"><?=$arPost["NAME"]?></div>							
				</div>
				<style>
					.social-buttons {cursor: default;}
					.comments-icon {cursor: default !important;}
				</style>
				<div class="photo_list_info">
					<?
						$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arPost['ID'], "PROPERTY_USER" => $USER->GetID() ),array());	
					?>
					<!--<a class="likes <?=($res_like>0)?"active":""?>" id="like_post_<?=$arPost["ID"]?>"></a>-->
					<div class="likes-wrap">
						<div id="<?=$GLOBALS['gl_like_id']?>" href="#" class="likes_tiser"></div>
						<div class="likes-number-tiser"><?=intval($arPost["PROPERTIES"]["LIKES"]["VALUE"])?></div>
					</div>
					<a class="comments-wrap">
								<div class="comments-icon"></div>
								<div class="comments-number"><?=intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"])?> <?=getNumEnding(intval($arPost["PROPERTIES"]["COMMENTS_COUNT"]["VALUE"]), Array("комментарий", "комментария", "комментариев"))?></div>
					</a>
					<?if($arPost["PROPERTIES"]["SHARE"]["VALUE"] == "Y"){?>
						<div class="socwrap">
							<!-- Кнопка репоста -->
							<div class="social-buttons"></div>
							 <span link="<?=urlencode("http://".SITE_SERVER_NAME."/group/1/photo/".$arPost["ID"].'/')?>" class= "fb_share_count" style="vertical-align: baseline; color:#fff; text-align:center; padding-top:4px; font-size: 11px;"></span>
						</div>
					<?}?>
					<!--<div class="photo_list_date">
						3 ч назад
					</div>		
					-->
				</div>
			</div>
            
   <!--       <div class="cover_bottom_info mobile-block" id="bottom_photo_list_item_<?=$arPost["ID"]?>">
              <div class="cover_bottom_info_inside">
                <div class="group_info_slogan">12345</div>
                <div class="mobile-block group_info_mobile-block">
                    <div><span>ДЕЙСТВИЯ</span><span>ПОДЕЛИТЕСЬ</span></div>
                    <div>
                        <div class="group_info_mobile-block_like"></div>
                        <div class="group_info_mobile-block_star"></div>
                        <div class="group_info_mobile-block_fb"></div>                    
                        <div class="group_info_mobile-block_vk"></div>                    
                        <div class="group_info_mobile-block_gplus"></div>                    
                    </div>
                </div>       
              </div>           
          </div>  -->
            
            
			<?
			//echo '<pre>'; print_r($arPost); echo '</pre>';		
		}
		?>
	</div>