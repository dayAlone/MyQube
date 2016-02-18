<div class="groups">
	<?foreach ($arResult['ITEMS'] as $key => $item) {?>
		<a href="<?=($key == 0 ? $item['DETAIL_PAGE_URL'] : ($USER->IsAuthorized() ? '#groupInvite': '#'))?>" <?=($USER->IsAuthorized() ? 'data-toggle="modal"' : "")?> class="groups__item">
			<div style="background-image: url(<?=str_replace(' ','%20', CFile::GetPath($item['PROPERTIES']['LIST_PICT']['VALUE']))?>)" class="groups__image"></div>
			<div class="groups__name"><?=$item['NAME']?></div>
			<div class="groups__users"><img src="/layout/images/svg/people.svg" alt=""><span><?=$item['PROPERTIES']['USERS'][VALUE]?></span> <?=pluralize($item['PROPERTIES']['USERS'][VALUE], array('участников', 'участников', 'участник', 'участника'))?></div>
			<div class="groups__lock"><img src="/layout/images/svg/lock-group.svg" alt=""><br><span class="hidden-xs">Это закрытая<br/> группа</span></div>
		</a>
	<? } ?>
</div>
<? if ($USER->IsAuthorized()) {?>
<div id="groupInvite" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content center">
		<h5>Для вступления в эту группу<br/>необходимо подать заявку</h5>
		<input type="email" name="email" value="" placeholder="Введите адрес электронной почты" class="input">
		<a data-dismiss="modal" href="#" class="close"><?=svg('close')?></a>
		<button type="submit" name="button" class="button button--small">отправить</button>
    </div>
  </div>
</div>
<?}?>
