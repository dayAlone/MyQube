<? 
$arPosts = array();
$iblock_id = 21;
if(!empty($_POST["performance"])) {
	$performance = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $iblock_id, "ID" => $_POST["performance"]));
	while($ob = $performance->GetNextElement()) {
		$arPerformance = $ob->GetFields();
		$arPerformance["PROPS"] = $ob->GetProperties();
	}
	$countUsers = $arPerformance["PROPS"]["SEATS"];
	if($countUsers["VALUE"] > 0) {
		$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 20, "NAME" => $_POST["code"]));
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
		}
		if($arFields["ID"] > 0 && empty($arProps["USER"]["VALUE"])) {
			$el = new CIBlockElement;
			$PROP = array();
			$PROP[141] = $_POST["performance"];
			$PROP[142] = $user_id;
			$PROP[145] = $arProps["AMBASSADOR"]["VALUE"];
			$arLoadProductArray = Array(
				"PROPERTY_VALUES"=> $PROP
			);
			$res = $el->Update($arFields["ID"], $arLoadProductArray);	
			$countUsers["VALUE"]--;
			CIBlockElement::SetPropertyValues($_POST["performance"], $iblock_id, $countUsers["VALUE"], "SEATS");
			$arUser = $USER->GetByID($user_id)->Fetch();
			$eventFields = array(
				"EMAIL" => $_POST["email"],
				"NAME" => $arUser["NAME"],
				"DATE" => date("H:m d.m.Y", strtotime($arPerformance["PROPS"]["DATE_START"]["VALUE"])),
				"QR_GIF" => "http://myqube.ru".CFile::GetPath($arFields["PREVIEW_PICTURE"])
			);
			CEvent::SendImmediate("PERFORMANCE", "s1", $eventFields, $Duplicate = "N", $message_id="33");
		} else {
			echo "Регистрация не удалась. Данный код уже был использован.";
		}
	} else {
		echo "Регистрация не удалась. Места закончились.";
	}
}
$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array("PROPERTY_DATE_FROM" => "ASC"), $arFilter, false, Array("nPageSize" => 5));
while($arItemObj = $res->GetNextElement()) {
	$arItem = $arItemObj->GetFields();
	$arItem["PROPERTIES"] = $arItemObj->GetProperties();
	$arItem["close"] = false;
	if($DB->CompareDates($arItem["PROPERTIES"]["DATE_FROM"]["VALUE"], date("d.m.Y H:i:s", strtotime("+4 hours"))) != 1 || $arItem["PROPERTIES"]["SEATS"]["VALUE"] == 0) {
		$arItem["close"] = true;
	}
	$arPosts[$arItem["ID"]] = $arItem;
}
?>
<!-- begin b-forms  -->
<div class="l-section b-forms" id="registration">
	<div class="b-section__title">регистрация*</div>
	<div class="b-forms-wrapper">
		<p>Здравствуйте,<br>если вы попали на эту страницу, значит вы в числе немногих приглашенных на наш уникальный городской спектакль.</p>
		<p>Выберите удобную для вас дату посещения,<br>а затем введите ваш персональный код доступа и адрес электронной почты, чтобы мы выслали вам приглашение.</p>
		<?foreach($arPosts as $key => $val) {?>	
			<script>
				$(document).ready(function(){
					$("#b-form_<?=$val["ID"]?>").submit(function(e) {
						var code_i = $(this).find('input[name="code"]'),
							email_i = $(this).find('input[name="email"]'),
							phone_i = $(this).find('input[name="phone"]');

						if((code_i.val()=="")){
							$.fancybox({
								href:"#code-error-modal",
								padding:0,
									helpers: {
										overlay: {
										  locked: false
										}
									}
								
							})
							return false;
						}else if((email_i.val()=="")){
							$.fancybox({
								href:"#email-error-modal",
								padding:0,
								helpers: {
								overlay: {
								  locked: false
								}
							}
							})
							return false;
						}else if((phone_i.val()=="")){
							$.fancybox({
								href:"#phone-error-modal",
								padding:0
							})
							return false;
						}else{
							data = $("#b-form_<?=$val["ID"]?>" ).serialize();
							$.ajax({
							  type: "POST",
							  url: "/group/u_concept/registration.php",
							  data: data,
							  success: function(data, textStatus, jqXHR)
							  {
								  if(data == 0) {								  
									$.fancybox({
										href:"#form-fail-modal",
										padding:0,
												helpers: {
												overlay: {
												  locked: false
												}
											}
									})		
								  } else if(data == 1){									  
									$.fancybox({
										href:"#form-success-modal",
										padding:0,
												helpers: {
												overlay: {
												  locked: false
												}
											}
									})		
								  } else if(data == 2) {							  
									$.fancybox({
										href:"#form-double-modal",
										padding:0,
												helpers: {
											overlay: {
											  locked: false
											}
										}
									})										  
								  } else if(data == 3) {							  
									$.fancybox({
										href:"#form-fail-modal",
										padding:0,
												helpers: {
											overlay: {
											  locked: false
											}
										}
									})										  
								  }
							 }
							})
							return false;			
						}		
						return false;
					});
				});
			</script>		
			<form class="b-form" method="post" id="b-form_<?=$val["ID"]?>">
				<div class="b-form__field">
					<p class="b-form__text"><?=FormatDate("d.m", MakeTimeStamp($val["PROPERTIES"]["DATE_FROM"]["VALUE"]))?></p>
				</div>
				<div class="b-form__field">
					<p class="b-form__text "><?=FormatDate("H:s", MakeTimeStamp($val["PROPERTIES"]["DATE_FROM"]["VALUE"]))?></p>
				</div>
				<div class="b-form__field">
					<p class="b-form__text b-form__text--lg"><?=$val["PROPERTIES"]["SEATS"]["VALUE"]?> <span class="b-form__text-sm">свободных<br>мест</span></p>
				</div>
				<div class="b-form__field-wrap">
					<input type="text" name="code" class="b-form__input" style="border: 1px solid #e86121;" placeholder="Введите ваш код" <?if($val["close"]) echo " disabled";?>>
					<input type="email" name="email" class="b-form__input" style="border: 1px solid #e86121;" placeholder="Введите ваш e-mail" <?if($val["close"]) echo " disabled";?>>
					<input type="text" name="phone" class="b-form__input" style="border: 1px solid #e86121;" placeholder="Введите ваш телефон" <?if($val["close"]) echo " disabled";?>>
				</div>
				<input type="hidden" name="performance" value="<?=$val["ID"]?>">
				<div class="b-form__field b-form__field--btn">
					<button type="submit" class="b-form__btn" <?if($val["close"]) echo " disabled";?>>OK</button>
				</div>
			</form>
		<?}?>
		<p>*Регистрация возможна только для совершеннолетних курильщиков.</p>
		<p>По вопросам регистрации на сеанс просим связаться с менеджером по телефону: 8 (905) 703 09 76</p>
	</div>
</div>
<!-- end b-forms -->