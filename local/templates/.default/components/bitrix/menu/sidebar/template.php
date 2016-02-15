<? if ($USER->IsAuthorized()) {?>
	<a class="sidebar-trigger">
	  <div class="sidebar-trigger__on">
		  <?=svg('nav')?>
	  </div>
	  <div class="sidebar-trigger__off">
		  <?=svg('arrow-left')?>
	  </div>
	</a>
	<div class="sidebar">
		<a href="#" class="sidebar__logo"><?=svg('logo')?></a>

		<div class="sidebar__nav nav">
			<?foreach ($arResult as $key => $item) {?>
				<a href="/user/profile/" class="nav__item">
					<?=svg('menu-'. $item['PARAMS']['CODE'])?>
					<span><?=$item['TEXT']?></span>
				</a>
			<?}?>
		</div>
	</div>
<? } ?>
