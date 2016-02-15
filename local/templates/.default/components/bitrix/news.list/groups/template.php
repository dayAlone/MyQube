<div class="groups">
	<?foreach ($arResult['ITEMS'] as $key => $item) {?>
		<a href="<?=$item['DETAIL_PAGE_URL']?>" class="groups__item">
			<div style="background-image: url(<?=urlencode($item['PREVIEW_PICTURE']['SRC'])?>)" class="groups__image"></div>
			<div class="groups__name"><?=$item['NAME']?></div>
			<div class="groups__users"><img src="/layout/images/svg/people.svg" alt=""><span><?=$item['PROPERTIES']['USERS'][VALUE]?></span> <?=pluralize($item['PROPERTIES']['USERS'][VALUE], array('участников', 'участников', 'участник', 'участника'))?></div>
			<div class="groups__lock"><img src="/layout/images/svg/lock-group.svg" alt=""><br><span class="hidden-xs">Это закрытая<br/> группа</span></div>
		</a>
	<? } ?>

</div>
