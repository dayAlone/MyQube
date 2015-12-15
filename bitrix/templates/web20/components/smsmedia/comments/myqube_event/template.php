<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="comments" id="comment_form_<?=$arParams['OBJECT_ID']?>">
	<div class="comm_header">КОММЕНТАРИИ</div>
	<?ShowError(implode("<br />", $arResult["ERRORS"]));?>
	<?if($arResult['SCROLL_TO_COMMENT']):?><script type="text/javascript">scrollToComment(<?=$arResult['SCROLL_TO_COMMENT']?>);</script><?endif;?>
	<script>
		function AjaxFormRequest(new_comment_form, form){
			$(".file-selectdialog-switcher").show();
			$(".file-selectdialog").hide();
					if($('#TEXT').val()){$('.formcom').attr("disabled","disabled");}
					$.ajax({url: '<?=SITE_TEMPLATE_PATH?>/components/smsmedia/comments/myqube_event/ajax.php',
					type:     "POST",
					dataType: "html", //Тип данных 
					data: jQuery("#"+new_comment_form).serialize(),
					success: function(data){
						if(data){
							var parentID = $("#new_comment_form"+form+" input[name=PARENT_ID]").val();
							if(!parentID)
								$('.comment-inner').append(data);
							else								
								$('#comment_'+parentID).append(data);
							$('.formcom').removeAttr('disabled');
							$(".answer_link"+form).css("display", "block");
							$('.comments'+form).append( $('form') );
							$("#new_comment_form"+form+" textarea").val('');
							$("#new_comment_form"+form+" input[name=PARENT_ID]").val('');
						}
		}});}
		/*function likeit(id){
					$.ajax({url: '<?=SITE_TEMPLATE_PATH?>/components/smsmedia/comments/myqube_event/ajax.php?id='+id,
					type:     "get",
					success: function(data){
						if(data){
							$("#likeit-"+id).text(data);
						}
		}});}*/
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
	<?
	$arr_comment = Array();
	?>
	<div class="comment-inner">
		<?if($arResult['COMMENTS_COUNT']):?>
			<?foreach($arResult['COMMENTS'] as $COMMENT):
			$arr_comment[$COMMENT['ID']] = $COMMENT;
			//echo "<xmp>";print_r($COMMENT);echo "</xmp>";
			?>
				<div class="comment flex-between" id="comment_<?=$COMMENT['ID']?>">	
					<?
					if($COMMENT['USER']['PERSONAL_PHOTO']!="")
						$file = CFile::ResizeImageGet($COMMENT['USER']['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
					else $file["src"]="/images/user_photo.png";
					?>
					<div class="gallery_comm_item_avatar" style="background-image: url('<?=$file["src"]?>');">
						<div <?if(CUser::IsOnLine($COMMENT['USER']["ID"],12000)) echo 'class="gallery_comm_item_avatar_online"';?>></div>
					</div>
					<?
					$username = ($COMMENT['USER']['NAME']!="")?($COMMENT['USER']['NAME'].' '.$COMMENT['USER']['LAST_NAME']):$COMMENT['USER']['LOGIN'];
					?>
					<div class="gallery_comm_item_info">
						<div class="gallery_comm_item_date"><?=$COMMENT['DATE_CREATE']?></div>
						<div class="gallery_comm_item_name">
							<?=$username?>
							<?if($COMMENT["DEPTH_LEVEL"] > 0) {?>
								<img class="gallery_comm_item_roundarr" src="<?=SITE_TEMPLATE_PATH?>/images/roundarr.png">
								<?
								$username_answer = ($arr_comment[$COMMENT["PARENT_ID"]]['USER']['NAME']!="")?($arr_comment[$COMMENT["PARENT_ID"]]['USER']['NAME'].' '.$arr_comment[$COMMENT["PARENT_ID"]]['USER']['LAST_NAME']):$arr_comment[$COMMENT["PARENT_ID"]]['USER']['LOGIN'];
								?>
								<span class="gallery_comm_item_answer">Ответ пользователю</span>
								<span class="gallery_comm_item_answer_name"><?=$username_answer?></span>
							<?}?>
						</div>
						<div class="gallery_comm_item_text"><?=strip_tags($COMMENT['TEXT'])?></div>
						<div class="otvet" id="reply_to_<?=$COMMENT['ID']?>">
							<a href="javascript:ReplyToComment('<?=$COMMENT['ID']?>', '<?=$username?>, ', '<?=$COMMENT["DEPTH_LEVEL"]?>');" class="answer_link<?=$arParams['OBJECT_ID']?>"><?=GetMessage('REPLY')?></a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<?endforeach;?>
		<?endif;?>
	</div>
	<div style="clear:both;"></div>
	<div class="head-form-comment">
		<form method="post"enctype="multipart/form-data" action="" id="new_comment_form<?=$arParams['OBJECT_ID']?>">
			<fieldset style="border: none;"> 
				<textarea name="TEXT" id="TEXT" placeholder="Написать комментарий"></textarea> 
				<input type="hidden" id="parent_id" name="PARENT_ID" value="" />
				<input type="hidden" id="parent_id_w" name="PARENT_ID_W" value="<?=$arParams['OBJECT_ID_W']?>" />
				<input type="hidden" name="url" value="<?=$_SERVER['HTTP_HOST'].$APPLICATION->GetCurUri();?>" />
				<input type="hidden" name="object" value="<?=$arParams['OBJECT_ID']?>" />
				<div class="comment_submit_button">
                <div class="mobile-block comment_submit_button-text" onclick="AjaxFormRequest('new_comment_form<?=$arParams['OBJECT_ID']?>', '<?=$arParams['OBJECT_ID']?>')">ОТПРАВИТЬ</div>
					<img class="formcom comments-button" src="<?=SITE_TEMPLATE_PATH?>/images/enter.png" alt="Отправить" title="Отправить" onclick="AjaxFormRequest('new_comment_form<?=$arParams['OBJECT_ID']?>', '<?=$arParams['OBJECT_ID']?>')" />
				</div>
			</fieldset> 
		</form>
	</div>
</div>