<?
	$user = $arResult['arUser'];
?>
<div class="age qblock">
  <div class="qblock__content"><img src="/layout/images/svg/logo-full.svg" alt="" class="age__logo">
	<p>
	  К сожалению, мы не смогли получить информацию <br/>
	  от социальной сети о вашем возрасте.<br/>
	  Чтобы продолжить, пожалуйста, укажите<br/>
	  дату вашего рождения.
	</p>
	<form data-parsley-validate method="post" action="<?=$_SERVER['REQUEST_URL']?>" enctype="multipart/form-data">
	  <?ShowError($arResult["strProfileError"]);?>
	  <input type="hidden" name="ID" value="<?=$user['ID']?>" />
	  <input type="hidden" name="LOGIN" value="<?=$user['LOGIN']?>" />
	  <input type="hidden" name="EMAIL" value="<?=$user['EMAIL']?>" />
	  <input type="hidden" name="save" value="Сохранить" />
	  <input type="hidden" name="lang" value="<?=LANG?>" />
	  <?=$arResult["BX_SESSION_CHECK"]?>
	  <input type="hidden" name="PERSONAL_BIRTHDAY" value="<?=$user['PERSONAL_BIRTHDAY']?>" class="age__input age__input--value">
	  <div class="row">
		<div class="col-xs-4">
		  <input value="<?=date('d', strtotime($user['PERSONAL_BIRTHDAY']));?>" type="text" name="DD" placeholder="Дд" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 31]" class="age__input">
		</div>
		<div class="col-xs-4">
		  <input value="<?=date('m', strtotime($user['PERSONAL_BIRTHDAY']));?>" type="text" name="MM" placeholder="Мм" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 12]" class="age__input">
		</div>
		<div class="col-xs-4">
		  <input value="<?=date('Y', strtotime($user['PERSONAL_BIRTHDAY']));?>" type="text" name="YYYY" placeholder="Гггг" required maxlength="4" data-parsley-minlength="4" data-parsley-range="[1930, 2016]" class="age__input">
		</div>
	  </div>
	  <button type="submit" class="button age__button">продолжить</button>
	</form>
	<div class="age__footer qblock__footer">
	  <? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	</div>
  </div>
</div>
