<?
	$item = $arResult;
	$props = $item['PROPERTIES'];
?>
<div class="groups">
  <div href="#" class="groups__item groups__item--big">
	<div style="background-image: url(http://myqube.ru/<?=$item['DETAIL_PICTURE']['SRC']?>)" class="groups__image"></div>
	<div class="groups__name"><?=$item['NAME']?></div>
	<div class="groups__description"><?=$item['PREVIEW_TEXT']?></div>
	<div class="groups__users"><img src="/layout/images/svg/people.svg" alt="">
		<?=$props['USERS'][VALUE]?></span> <?=pluralize($props['USERS'][VALUE], array('участников', 'участников', 'участник', 'участника'))?>
	</div>
	<div class="groups__lock"><img src="/layout/images/svg/lock-group.svg" alt=""><br><span class="hidden-xs">Это закрытая<br/> группа</span></div>
  </div>
</div>
