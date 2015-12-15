<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(CModule::IncludeModule("main")){
	if(CModule::IncludeModule("iblock")){
		/* ADDING NEW COMMENT START */
		if(!empty($_POST['TEXT']))
		{
			$ERRORS = array();
			$user = $USER->GetID();
			if(strlen($_POST['TEXT']) && !empty($user))
			{
				$_POST['TEXT'] = htmlspecialchars($_POST['TEXT']);
				$_POST['TEXT'] = strip_tags($_POST['TEXT']);
				$el = new CIBlockElement;
				$PROPS = array();
				$PROPS['USER_IN'] = intval($_POST['to_id']);
				$PROPS['READ'] = 0;

				$arLoadProductArray = Array(
					"MODIFIED_BY"    => $USER->GetID(),
					"IBLOCK_SECTION_ID" => false,
					"IBLOCK_ID"      => 12,
					"PROPERTY_VALUES"=> $PROPS,
					"NAME"           => "mes",
					"PREVIEW_TEXT"    => $_POST['TEXT'],
					"ACTIVE"         => "Y"
				);
				$PROPS_Tmp = $PROPS;
				$PROPS_Tmp['IN_OUT'] = min($USER->GetID(),$PROPS['USER_IN'])."_".max($USER->GetID(),$PROPS['USER_IN']);
				$arLoadProductArrayTmp = Array(
					"MODIFIED_BY"    => $USER->GetID(),
					"IBLOCK_SECTION_ID" => false,
					"IBLOCK_ID"      => 15,
					"PROPERTY_VALUES"=> $PROPS_Tmp,
					"NAME"           => "mes",
					"PREVIEW_TEXT"    => $_POST['TEXT'],
					"ACTIVE"         => "Y"
				);
				$rsMess = CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>15,"PROPERTY_IN_OUT"=>min($USER->GetID(),$PROPS['USER_IN'])."_".max($USER->GetID(),$PROPS['USER_IN'])),Array("ID"),false);
				$Mess   = $rsMess->Fetch();
				if(empty($Mess))
				{
					$el_tmp = new CIBlockElement;
					$el_tmp->Add($arLoadProductArrayTmp);
				}
				else
				{
					$el_tmp = new CIBlockElement;
					$arLoadProductArrayTmp=Array(
						"PREVIEW_TEXT"    => $_POST['TEXT'],
						"PROPERTY_VALUES"=> $PROPS_Tmp
					);					
					$el_tmp->Update($Mess["ID"],$arLoadProductArrayTmp);
				}
				if($NEW_ID = $el->Add($arLoadProductArray))
				{
					$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
					$username = ($CurentUser['NAME']!="")?($CurentUser['NAME'].' '.$CurentUser['LAST_NAME']):$CurentUser['LOGIN'];
					
					if($CurentUser['PERSONAL_PHOTO']!="")
							$file_user_current = CFile::ResizeImageGet($CurentUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
						else $file_user_current["src"]="/images/user_photo.png";
					
					
					?>		
						<!-- Блок каментов -->
						<div class="comment-wrap my-comment">
							<!-- Блок камента -->
							<div class="comment">
							<!-- Блок аватара -->
								<div class="avatar">
									<div class="user-photo" style="background:url('<?=$file_user_current["src"]?>')">
									<!-- Внешняя окружность статуса -->
										<div class="opcircl">
										<!-- Кружок статуса. Цвет прописывается классом -->
											<div class="colorcrcl  red-satus"></div>
										</div>
									</div>
									<div class="status"></div>
								</div>
								<!-- Блок текста(Имя + текст камента) -->
								<div class="right-text">
								<!-- Имя автора камента -->
									<div class="user-name"><span class="user-name-text"><?=$username?></span></div>
								<!-- Текст камента -->
									<div class="comment-text"><?=$_POST['TEXT']?></div>
								</div>
							</div>
							<div class="comment-date"><?=date("d.m.y - H:i",time());?></div>
						</div>	
					<!--
					<?echo '<div class="comment" id="comment_'.$NEW_ID.'" style="'.$otstup.'">'.$reaply;
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
		-->
					<?
					$_POST['TEXT'] = '';
				}
			}
		}
	}
}
?>