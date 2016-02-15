<?
	$user = $arResult['arUser'];
?>
 <div class="welcome qblock">
   <div class="qblock__content">
	 <div class="welcome__user">
	   <div style="background-image: url(<?=CFile::GetPath($user['PERSONAL_PHOTO'])?>)" class="welcome__avatar"></div>
	   <div class="welcome__name"><?=$user['NAME']?></div>

	   <div class="welcome__about">
		   <? if (strlen($user["PERSONAL_BIRTHDAY"]) > 0):?>
		    <?=FormatDate("d F", MakeTimeStamp($user["PERSONAL_BIRTHDAY"]))?> <br/>
		   <?
   			endif;
			if (strlen($user["PERSONAL_CITY"]) > 0):
		   ?>Живет в <?=$user['PERSONAL_CITY']?><?

	   		endif;?>
	   </div>
	 </div><a href="/user/profile/?edit=y" class="welcome__action action">

	   Мой профиль
	   <div class="action__counter"><img src="/layout/images/svg/edit.svg"></div><img src="/layout/images/svg/blue-arrow.svg" class="action__arrow"></a><br><a href="#" class="welcome__action action">

	   Друзья
	   <div class="action__counter"><?=(count($user['UF_FRIENDS']) > 0 ? count($user['UF_FRIENDS']) : '')?></div><img src="/layout/images/svg/blue-arrow.svg" class="action__arrow"></a><br><a href="#" class="welcome__action action">

	   Группы
	   <div class="action__counter"><?=(count($user['UF_GROUPS']) > 0 ? count($user['UF_GROUPS']) : '')?></div><img src="/layout/images/svg/blue-arrow.svg" class="action__arrow"></a>
	 <div class="row">
	   <div class="col-xs-6 left"><a href="/group/" class="welcome__link welcome__link--settings"><?=svg('settings')?>Настройки</a></div>
	   <div class="col-xs-6 right"><a href="/?logout=yes" class="welcome__link"><?=svg('menu-exit')?>Выйти</a></div>
	 </div>
	 <div class="welcome__footer qblock__footer">
	   <? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	 </div>
   </div>
 </div>
