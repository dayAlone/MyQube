<script type="text/javascript">
$(function(){
		$('.chat-add-search input').keyup(function() { 
			$(".chat .comment_chat").each(function(){
				if($('.chat-add-search input').val()=='' || $(this).find(".user-name").html().toLowerCase().indexOf($('.chat-add-search input').val().toLowerCase())>=0)
					$(this).show();
				else
					$(this).hide();
			});
		});
	});
</script>
<?
	$CurentUser = CUser::GetByID($USER->GetID())->Fetch();
	$order = array('sort' => 'asc');
	$tmp = 'sort'; 

	<?if(!empty($CurentUser["UF_FRIENDS"])) {?>
		$rsUsers = CUser::GetList($order, $tmp, Array("ID"=>implode('|', $CurentUser["UF_FRIENDS"])));
	<?}?>

?>
<link type="text/css" rel="stylesheet" href="/css/chat.css">
<div class="chat">
			<!-- Блок поиска -->
			<div class="chat-add-search">
				<input type="text"  placeholder="">
				<div class="search-block"></div>
			</div>
			<div class="chat-head">ДРУЗЬЯ</div>
			<!-- Блок каментов -->
			<!-- Блок камента -->
			<?if(!empty($CurentUser["UF_FRIENDS"])) {?>
				<?while($arUser = $rsUsers->Fetch()) {?>
				<div class="comment_chat" >
					<a class="avatar_chat" title="Открыть профиль" href="/user/<?=$arUser['ID']?>/profile/">
					<?if($arUser['PERSONAL_PHOTO']!="")
						$file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
					else $file["src"]="/images/user_photo.png";?>
						<div class="user-photo_chat" style="background:url('<?=$file["src"]?>')">
							<div class="opcircl">
								<div class="colorcrcl <?=$USER->IsOnLine($arUser['ID'], 900) ? 'green-satus' : 'red-satus';?>"></div>
							</div>
						</div>
						<div class="status"></div>
					</a>
					<div class="right-text_chat">
					<? $username = ($arUser['NAME']!="")?($arUser['NAME'].' '.$arUser['LAST_NAME']):$arUser['LOGIN'];?>
						<a href="/communication/<?=$arUser['ID']?>/" title="Открыть переписку" class="user-name"><?=$username ?></a>
					</div>
				</div>
				<?}?>
			<?}?>
	</div>