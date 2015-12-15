<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="comments" id="comment_form_<?=$arParams['OBJECT_ID']?>">
	<? ShowError(implode("<br />", $arResult["ERRORS"])); ?>
	<? if($arResult['SCROLL_TO_COMMENT']):?>
		<script type="text/javascript">scrollToComment(<?=$arResult['SCROLL_TO_COMMENT']?>);</script>
	<? endif;?>
	<script>
		function AjaxFormRequest(new_comment_form, form){
			$(".file-selectdialog-switcher").show();
			$(".file-selectdialog").hide();
					if($('#TEXT').val()){$('.formcom').attr("disabled","disabled");}
					$.ajax({url: '<?=SITE_TEMPLATE_PATH?>/components/smsmedia/comments/myqube/ajax.php',
					type:     "POST",
					dataType: "html", //Тип данных 
					data: jQuery("#"+new_comment_form).serialize(),
					success: function(data){
						if(data){
							var parentID = $("#new_comment_form"+form+" input[name=PARENT_ID]").val();
							if(!parentID)
								$('.comment-inner noindex').append(data);
							else								
								$('#comment_'+parentID).append(data);
							$('.formcom').removeAttr('disabled');
							$(".answer_link"+form).css("display", "block");
							$('.comments'+form).append( $('form') );
							$("#new_comment_form"+form+" textarea").val('');
							$("#new_comment_form"+form+" input[name=PARENT_ID]").val('');
						}
		}});}
		function likeit(id){
					$.ajax({url: '/bitrix/components/smsmedia/comments/templates/.default/ajax.php?id='+id,
					type:     "get",
					success: function(data){
						if(data){
							$("#likeit-"+id).text(data);
						}
		}});}
		function bsubmit(){
			$(".authcom").css("display", "none");
			$(".formcom").css("display", "block");
		}
		$(function(){
			$('#TEXT').keydown(function (e) {
		 	   if (e.ctrlKey && e.keyCode == 13) {
		    	   AjaxFormRequest('new_comment_form<?=$arParams['OBJECT_ID']?>', '<?=$arParams['OBJECT_ID']?>')
		  	 	}
			});
		});	
	</script>
	<div class="head-form-comment">
			<form method="post"enctype="multipart/form-data" action="" id="new_comment_form<?=$arParams['OBJECT_ID']?>">
				<fieldset style="border: none;"> 
					<textarea name="TEXT" id="TEXT" placeholder="Написать комментарий"></textarea> 
					<input type="hidden" id="parent_id" name="PARENT_ID" value="" />
					<input type="hidden" name="url" value="<?=$_SERVER['HTTP_HOST'].$APPLICATION->GetCurUri();?>" />
					<input type="hidden" name="object" value="<?=$arParams['OBJECT_ID']?>" />
					<div class="comment_submit_button">
						<img class="formcom comments-button" src="<?=SITE_TEMPLATE_PATH?>/images/enter.png" alt="Отправить" title="Отправить" onclick="AjaxFormRequest('new_comment_form<?=$arParams['OBJECT_ID']?>', '<?=$arParams['OBJECT_ID']?>')" />
					</div>
				</fieldset> 
			</form>
	</div>
	<div class="comment-inner">
	<? if($arResult['COMMENTS_COUNT']): ?>
		<? if($arResult['NO_INDEX'] == 'Y'):?><noindex><? endif;?>
		<? foreach($arResult['COMMENTS'] as $COMMENT): ?>		
		<?if($COMMENT["END"] == "Y")
			echo '</div>';
		else {?>
		<div class="comment" id="comment_<?=$COMMENT['ID']?>"<?if($COMMENT["DEPTH_LEVEL"] > 0) echo 'style="margin-left:65px"';?>><?if($COMMENT["DEPTH_LEVEL"] > 0) echo '<div class="reaply"></div>';?>
		
			<div class="head-comm">
				<? if($arResult['SHOW_USERPIC'] == 'Y'):?>
				<?$photo=CFile::GetPath($COMMENT['USER']['PERSONAL_PHOTO']);?>
				<a href="<?=$COMMENT['USER']['EXTERNAL_AUTH_ID']?>" target="_blank"><img src="<?if(!empty($photo)){echo $photo;}else{echo '/upload/medialibrary/f4f/f4f01f838375bff7a2e27ef75ecbbc0f.jpg';}?>" width="60" alt="<?echo $COMMENT['USER']['NAME'].' '.$COMMENT['USER']['LAST_NAME'];?>" /></a>
				<?if(CUser::IsOnLine($COMMENT['USER']["ID"]))
					echo "<div style='  height: 2px;
  background: rgb(0, 191, 0);
  position: absolute;
  bottom: 4px;
  width: 100%;'></div>";?>
				<? endif; ?>
			</div>
			<div class="text-comm">
				<div style="margin:0 5px 5px;">
					<a href="<?=$COMMENT['USER']['EXTERNAL_AUTH_ID']?>" target="_blank"><span class="login"><?echo $COMMENT['USER']['NAME'].' '.$COMMENT['USER']['LAST_NAME'];?></span></a>
				</div>
				<div class="text" style="margin:7px 40px; color:#404040;"><?=$COMMENT['TEXT']?> 
					<?if($COMMENT['FILE']) {?>
						<span class="comment-img"><?=CFile::Show2Images($COMMENT['PREVIEW_PICTURE'], $COMMENT['FILE']['ID'], 50, 50, "style='margin-left: -5px; margin-top: -5px;'")?></span>
					<?}?></div>
				<? if($arResult['CAN_COMMENT'] == 'Y'):?>
				<div class="otvet" id="reply_to_<?=$COMMENT['ID']?>">
					<?if($arResult['SHOW_DATE'] == 'Y') echo '<span class="time">'.$COMMENT['DATE_CREATE'].'</span>'; ?>
					<a href="javascript:ReplyToComment('<?=$COMMENT['ID']?>', '<?=$COMMENT['USER']['NAME'].' '.$COMMENT['USER']['LAST_NAME']?>, ', '<?=$COMMENT["DEPTH_LEVEL"]?>');" class="answer_link<?=$arParams['OBJECT_ID']?>"><?=GetMessage('REPLY')?></a>
				</div>
				<? endif; ?>
			</div>
			<?}?>
		<? endforeach; ?>
	<? endif; ?>
	</div>
<div style="clear:both;"></div>
</div><?//echo '<pre>'; print_r($arResult['COMMENTS']); echo '</pre>';?>
<? if($arResult['NO_INDEX'] == 'Y'):?></noindex><? endif;?>