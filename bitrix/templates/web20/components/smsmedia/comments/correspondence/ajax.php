<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(CModule::IncludeModule("main")){
	if(CModule::IncludeModule("iblock")){
		/* ADDING NEW COMMENT START */
		if(!empty($_POST['TEXT']))
		{
			$ERRORS = array();
			if($_POST['PARENT_ID'] == 0) $_POST['PARENT_ID'] = false;
			$user = $USER->GetID();
			if(strlen($_POST['TEXT']) && !empty($user) && empty($_POST['testForm']))
			{
				$_POST['TEXT'] = htmlspecialchars($_POST['TEXT']);
				$_POST['TEXT'] = strip_tags($_POST['TEXT']);
				$el = new CIBlockElement;
				$PROPS = array();
				$PROPS['AUTHOR'] = $USER->GetID();
				$PROPS['OBJECT_ID'] = $_POST['object'];
				$PROPS['OTVET_NA'] = $_POST['PARENT_ID'];
				$PROPS['FILE'] = $_POST['FILE'];
				$preview = CFile::ResizeImageGet($_POST['FILE'], array('width'=>120, 'height'=>120), BX_RESIZE_IMAGE_PROPORTIONAL, false);
				$arLoadProductArray = Array(
					"MODIFIED_BY"    => $USER->GetID(),
					"IBLOCK_SECTION_ID" => false,
					"IBLOCK_ID"      => 12,
					"PROPERTY_VALUES"=> $PROPS,
					"NAME"           => "Коммент",
					"ACTIVE"         => "Y",
					"DETAIL_TEXT"    => $_POST['TEXT'],
					"PREVIEW_PICTURE"    => CFile::MakeFileArray($preview["src"])
				);
				if($NEW_ID = $el->Add($arLoadProductArray))
				{
					$rsUser = CUser::GetByID($USER->GetID()); 
					$user = $rsUser->Fetch(); 
					//$photo=
					$file = CFile::ResizeImageGet($user['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
					$rsFile = CFile::GetByID($arFields["PROPERTY_FILE_VALUE"]);
					$arFile = $rsFile->Fetch();
					if(!empty($_POST['PARENT_ID'])) {
						$reaply = '<div class="reaply"></div>';
						$_POST['depth_level']++;
						$otstup = 'margin-left:65px;';
					}
					echo '<div class="comment" id="comment_'.$NEW_ID.'" style="'.$otstup.'">'.$reaply;
?>
					<div class="gallery_comm_item_avatar" style="background-image: url('<?=$file["src"]?>');">
						<div class="gallery_comm_item_avatar_online"></div>
					</div>
					<div class="gallery_comm_item_info">
						<div class="gallery_comm_item_date"><?=FormatDate(array(
												"tommorow" => "tommorow, H:i",
												"today" => "today в H:i",
												"yesterday" => "yesterday, H:i",
												"d" => 'j F Y, H:i',
												"" => 'j F Y, H:i'
											), (time()-(60*60)), time())?></div>
						<div class="gallery_comm_item_name">
							<?=$user['NAME'].' '.$user['LAST_NAME'];?>
							<?if($COMMENT["DEPTH_LEVEL"] > 0) {?>
								<img class="gallery_comm_item_roundarr" src="<?=SITE_TEMPLATE_PATH?>/images/roundarr.png">
								<span class="gallery_comm_item_answer">Ответ пользователю</span>
								<span class="gallery_comm_item_answer_name"><?=$USER->GetFirstName()?></span>
							<?}?>
						</div>
						<div class="gallery_comm_item_text"><?=$COMMENT['TEXT']?></div>
						<div class="otvet" id="reply_to_<?=$COMMENT['ID']?>">
							<a href="javascript:ReplyToComment('<?=$COMMENT['ID']?>', '<?=$USER->GetFirstName().' '.$USER->GetLastName()?>, ', '<?=$_POST['depth_level']?>');" class="answer_link<?=$arParams['OBJECT_ID']?>"><?=GetMessage('REPLY')?></a>
						</div>
					</div>
					<div class="clear"></div>
					
				</div>
					<?
					$_POST['TEXT'] = '';
					$_POST['NAME'] = '';
					// $this->ClearResultCache();
				}
			}
			else 
			{
				if(!strlen($_POST['TEXT'])) $arResult['ERRORS'][] = GetMessage('COMMENT_NOT_FILLED');
			}
		}
	}
}
?>