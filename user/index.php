<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$page_name="lenta";?>

<style>  
	.post-soc {
		bottom: 0;
		height: 30px;
		position: absolute;
	}	
	a.likes {
		margin-left:20px;
	}
	.social-buttons {
		margin-left:25px;
	}
	.post-text {
		padding-left:50px;
		margin-top:10px;
	}
	.user-name {
		/*margin-left:60px;*/
	}
	.likes-wrap {
		width:60px !important;
	}
	.likes-number {
		color:#000 !important;
	}
</style>
<script>
/*$(function(){
				$("a.photo_list_like" ).click(function() {
							$( this ).toggleClass( "like_active" );
							var path = host_url+"/group/lenta/like_post.php";
							$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "like_active" ))}, function(data){
							});
						});
			});*/
			</script><?
include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
?>		<?
			CModule::IncludeModule("iblock");
			$arSelect = Array("ID", "IBLOCK_ID", "*");
			$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ANC_ID" => $CurentUser["ID"], "PROPERTY_ANC_TYPE" => 21);
			$res = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arProps = $ob->GetProperties();
				$arPost[$arFields["ID"]] = $arFields;
				$arPost[$arFields["ID"]]["PROPERTIES"] = $arProps;
				$CreatedBy = CUser::GetByID($arFields["CREATED_BY"])->Fetch();
				if($CreatedBy['PERSONAL_PHOTO']!="")
					$file = CFile::ResizeImageGet($CreatedBy['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
				else $file["src"]="/images/user_photo.png";
				?>					
				<div class="post" style="position: relative;">
					<div class="post-head">
						<div class="comment">
							<div class="avatar">
								<a href="/user/<?=$CreatedBy["ID"]?>/profile/">
									<div class="user-photo" style="background-image: url('<?=$file["src"]?>');"></div>
								</a>
								<div class="status"></div>
							</div>
							<a href="/user/<?=$CreatedBy["ID"]?>/profile/">
							<div class="right-text">
								<div class="user-name"><?=$CreatedBy["NAME"]?></div>
							</div>
							</a>
							<div class="comment-date">
								<?=FormatDate(array(
									"tommorow" => "tommorow",
									"today" => "today",
									"yesterday" => "yesterday",
									"d" => 'j F',
									 "" => 'j F Y',
									), MakeTimeStamp($arFields["DATE_CREATE"]))?>
							</div>
						</div>
					</div>
					<div class="post-text">
						<?=$arFields["PREVIEW_TEXT"]?>
						<br><br>
						<?
						if($arProps["VIDEO"]["VALUE"]) {
							$parsed_url = parse_url($arProps["VIDEO"]["VALUE"]);
							parse_str($parsed_url['query'], $parsed_query);
							echo '<iframe src="http://www.youtube.com/embed/'.$parsed_query['v'].'" allowfullscreen="" width="100%" height="250px" frameborder="0"></iframe>';
						}
						?>
					</div>
					<?
					$res_like = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "PROPERTY_LIKE" => $arFields["ID"], "PROPERTY_USER" => $USER->GetID() ),array());	
					?>
					<div class="post-soc">
						<!--<div class="photo_list_info">-->
							<!--<a class="likes photo_list_like  <?=($res_like>0)?"like_active":""?>" id="like_post_<?=$arFields["ID"]?>" style="margin-left:20px;"></a>-->
						<?
							$GLOBALS['gl_active'] = $res_like;
							$GLOBALS['gl_like_id'] = "like_post_".$arFields["ID"];
							$GLOBALS['gl_like_numm'] = intval($arProps["LIKES"]["VALUE"]);
							$GLOBALS['gl_like_param'] = "post_id";
							$GLOBALS['gl_like_js'] = ($GLOBALS['gl_like_js']==1)?0:1;
							$GLOBALS['gl_like_url'] = "/group/lenta/like_post.php";
							$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
								"AREA_FILE_SHOW" => "file", 
								"PATH" => "/like.php"
								)
							);
						?>
						<!--</div>-->
						<!--a class="comments-wrap">
							<div class="comments-icon"></div>
						</a>
						<div class="social-buttons"></div-->
					</div>
					<?/*if($arProps["FILES"]["VALUE"]) {?>
						<a href="#" download style="text-transform: uppercase; color: #8d9298; position: absolute; right: 20px; bottom: 10px;">Имеются файлы для скачивания <img style="vertical-align: middle; padding: 0 5px;" src="/images/download.png"></a>
					<?}*/?>
					<?if($USER->IsAdmin()||$arFields["CREATED_BY"]==$USER->GetID()){?>
						<a class="editing" style="bottom: 10px; top:auto;" title="редактировать">•••</a>
						<div class="editing_menu editing_menu_post">
							<div class="editing_menu_delete"><a href="#" class="editing_menu_delete_i" id="<?=$arFields["ID"]?>">Удалить</a></div>
							<div class="editing_menu_cancel">Отмена</div>
						</div>
					<?}?>
				</div>
				<?
			}
			?>
		</div>
	<?	$APPLICATION->IncludeComponent(
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
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>