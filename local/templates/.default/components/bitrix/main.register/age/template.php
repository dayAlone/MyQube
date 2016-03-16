<?
	$data = json_decode($_REQUEST['fields'], true);
	if (count($data) == 0) LocalRedirect('/');
	$data['UF_YOU_HAVE_18'] = 1;
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
	  <? if (count($arResult["ERRORS"]) > 0): ?>
		<div class='login__errors login__errors--active'>
			<?=implode("<br/>", $arResult["ERRORS"])?>
		</div>
	  <?endif;?>

	  <input type='hidden' name='fields' value='<?=$_REQUEST['fields']?>'/>
	  <input type='hidden' name='backurl' value='<?=$_REQUEST['backurl']?>'/>
	  <input type="hidden" name="register_submit_button" value="Регистрация">
	  <?
		  foreach ($data as $key => $value) {
			?><input type='hidden' name='<?=preg_match('/UF/', $key) > 0 ? $key : 'REGISTER['.$key.']'?><?=preg_match('/PROFILE/', $key) ? '[]':''?>' value='<?=is_array($value) ? json_encode($value) : $value?>'/><?
		  }
	  ?>
	  <input type="hidden" name="save" value="Сохранить" />
	  <?=$arResult["BX_SESSION_CHECK"]?>
	  <input type="hidden" name="REGISTER[PERSONAL_BIRTHDAY]" value="<?=$_REQUEST['DD']?>.<?=$_REQUEST['MM']?>.<?=$_REQUEST['YYYY']?>" class="age__input age__input--value">
	  <div class="row">
		<div class="col-xs-4">
		  <input value="<?=$_REQUEST['DD']?>" type="text" name="DD" placeholder="Дд" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 31]" class="age__input">
		</div>
		<div class="col-xs-4">
		  <input value="<?=$_REQUEST['MM']?>" type="text" name="MM" placeholder="Мм" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 12]" class="age__input">
		</div>
		<div class="col-xs-4">
		  <input value="<?=$_REQUEST['YYYY']?>" type="text" name="YYYY" placeholder="Гггг" required maxlength="4" data-parsley-minlength="4" data-parsley-range="[1930, 2016]" class="age__input">
		</div>
	  </div>
	  <button disabled="disabled" type="submit" class="button age__button">продолжить</button>
	</form>
	<div class="age__footer qblock__footer">
	  <? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	</div>
  </div>
</div>
