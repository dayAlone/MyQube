<?
	$user = $arResult['arUser'];
?>
<div class="signup qblock">
  <div class="signup__content">
	<div class="signup__title">РЕГИСТРАЦИЯ</div>
	<div class="signup__description">
	  Мы приветствуем Вас на странице самого<br>
	  стильного закрытого сообщества Kent Lab!
	</div>
	<form data-parsley-validate method="POST">
	  <?ShowError($arResult["strProfileError"]);?>
	  <input type="hidden" name="ID" value="<?=$user['ID']?>">
	  <input type="hidden" name="LOGIN" value="<?=$user['LOGIN']?>" />
	  <input type="hidden" name="save" value="Сохранить">
	  <input type="hidden" name="PERSONAL_BIRTHDAY" value="<?=$user['PERSONAL_BIRTHDAY']?>">
	  <?=$arResult["BX_SESSION_CHECK"]?>
	  <div class="row no-gutter signup__name">
		<div class="col-sm-6 col-xs-12 left">
			<input type="text" name="NAME" data-parsley-minlength="2" data-parsley-pattern="[a-zA-Zа-яА-Я]" placeholder="Ваше имя" value='<?=$user['NAME']?>' required class="signup__input"><br>
		</div>
		<div class="col-sm-6 col-xs-12 right">
			<input type="text" name="LAST_NAME" data-parsley-minlength="2" data-parsley-pattern="[a-zA-Zа-яА-Я]" placeholder="Ваша фамилия" value='<?=$user['LAST_NAME']?>' required class="signup__input"><br>
		</div>
	  </div>
	  <input type="email" name="EMAIL" placeholder="Ваш адрес электронной почты" value="<?=$user['EMAIL']?>" required class="signup__input">
	  <div class="row no-gutter">
		<div class="col-xs-3 left">
		  <label class="signup__label">Дата<br/>рождения</label>
		</div>
		<div class="col-xs-9 right">
			<input disabled readonly value="<?=(strlen($user['PERSONAL_BIRTHDAY']) > 0 ? date('d', strtotime($user['PERSONAL_BIRTHDAY'])) : '');?>" type="text" name="DD" placeholder="Дд" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 31]" class="signup__input signup__input--small">
			<input disabled readonly value="<?=(strlen($user['PERSONAL_BIRTHDAY']) > 0 ? date('m', strtotime($user['PERSONAL_BIRTHDAY'])) : '');?>" type="text" name="MM" placeholder="Мм" required maxlength="2" data-parsley-minlength="1" data-parsley-range="[1, 12]" class="signup__input signup__input--small">
			<input disabled readonly value="<?=(strlen($user['PERSONAL_BIRTHDAY']) > 0 ? date('Y', strtotime($user['PERSONAL_BIRTHDAY'])) : '');?>" type="text" name="YYYY" placeholder="Гггг" required maxlength="4" data-parsley-minlength="4" data-parsley-range="[1930, 2016]" class="signup__input signup__input--small">
		</div>
	  </div>
	  <input type="text" name="UF_BRAND_1" value="<?=$user['UF_BRAND_1']?>" placeholder="Предпочитаемая марка сигарет 1" required class="signup__input"><br>
	  <input type="text" name="UF_BRAND_2" value="<?=$user['UF_BRAND_2']?>" placeholder="Предпочитаемая марка сигарет 1" required class="signup__input">
	  <div class="row no-gutter signup__agreement">
		<div class="col-sm-6 col-xs-12">
		  <div class="checkbox signup__checkbox">
			<input type="checkbox" name="UF_DO_YOU_SMOKE" value="1" id="UF_DO_YOU_SMOKE" <?=($user['UF_DO_YOU_SMOKE'] == 1 ? "checked" : "")?> required class="checkbox__input">
			<label for="UF_DO_YOU_SMOKE" class="checkbox__label">Я подтверждаю, что являюсь совершеннолетним курильщиком</label>
		  </div>
		</div>
		<div class="col-sm-6 col-xs-12">
		  <div class="checkbox signup__checkbox">
			<input type="checkbox" name="UF_IAGREE" value="1" id="UF_IAGREE" <?=($user['UF_IAGREE'] == 1 ? "checked" : "")?> required class="checkbox__input">
			<label for="UF_IAGREE" class="checkbox__label">Даю согласие на обработку моих персо&shy;нальных данных</label>
		  </div>
		</div>
	  </div><a href="#" class="signup__agreement-trigger">Показать текст соглашения</a><br>
	  <button type="submit" class="signup__button">Присоединиться к группе kent lab</button>
	  <div class="signup__footer qblock__footer">
		© 2015 MyQube. все права защищены. <br>
		социальная сеть предназначена для лиц старше&nbsp;18 лет
	  </div>
	</form>
  </div>
</div>
