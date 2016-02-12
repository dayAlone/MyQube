<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Добавить контакт");?>
<?//$APPLICATION->AddHeadScript("/js/plugins/jquery-datetimepicker/jquery.datetimepicker.js");?>
<?//$APPLICATION->SetAdditionalCSS("/js/plugins/jquery-datetimepicker/jquery.datetimepicker.css");?>
<div class="show-message"></div>
<ul class="menu"><li><a href="javascript:void(0)">Добавить контакт</a></li></ul>
<div class="add-user-error">
<?if(isset($_POST["Data"]["User"])){//htmlspecialcharsbx
	if(CustomUser::Set($_POST["Data"]["User"])) {
		LocalRedirect("/amplifiers/?add_user=Y");
	} else {
		LocalRedirect("/amplifiers/?add_user=N");
	}
	echo ShowError(CustomUser::$TextError);
}?>
</div>
<form class="add-user" method="POST" id="amplifiers_form">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td colspan="3">
				 <input 
				 	placeholder="Имя" 
					type="text" 
					name="Data[User][NAME]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["NAME"]);?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td colspan="3">
				<input 
					placeholder="Фамилия" 
					type="text" 
					name="Data[User][LAST_NAME]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["LAST_NAME"]);?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td colspan="3">
				<input 
					placeholder="Email" 
					type="text" 
					onchange="ActiveButtonSend(this);"
					name="Data[User][EMAIL]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["EMAIL"]);?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td colspan="3">
				<input 
					placeholder="Мобильный телефон" 
					onchange="ActiveButtonSend(this);"
					type="text" 
					name="Data[User][PERSONAL_MOBILE]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["PERSONAL_MOBILE"]);?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td colspan="3">
				<input 
					placeholder="Дата рождения ДД.ММ.ГГГГ" 
					type="text" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["PERSONAL_BIRTHDAY"]);?>"
					name="Data[User][PERSONAL_BIRTHDAY]" required />
			</td>
		</tr>
		<tr>
			<td></td>
			<td class="add-user-age" colspan="3">
				<input 
					<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_DO_YOU_SMOKE"]) == 1 ? " checked=\"checked\" " : "";?>
					type="checkbox" 
					onchange="ActiveButtonSend(this);"
					name="Data[User][UF_DO_YOU_SMOKE]" 
					value="1"/>
				<span>
					Я подтверждаю, что мне  
					<input 
						type="text" 
						name="Data[User][AGE]" 
						size="2"
						onchange="ActiveButtonSend(this);"
						value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["AGE"]);?>"/> 
					лет, и  я являюсь совершеннолетним курильщиком
				</span>
				<input 
					type="hidden" 
					name="Data[User][UF_YOU_HAVE_18]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_YOU_HAVE_18"]);?>"/>
			</td>
		</tr>
		<tr>
			<td>
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td>
				<input 
					placeholder="Марка 1" 
					type="text" 
					name="Data[User][UF_BRAND_1]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_BRAND_1"]);?>"/>
			</td>
			<td class="add-user-td-padding">
				<img src="/images/amplifiers/amplifiers_icons_1.png"/>
			</td>
			<td>
				<input 
					placeholder="Марка 2" 
					type="text" 
					name="Data[User][UF_BRAND_2]" 
					value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_BRAND_2"]);?>"/>
			</td>
		</tr>
	</table>
	<div class="add-user-socialnetwork">
		<div class="add-user-socialnetwork-f">
			<a target="_blank" href="https://ru-ru.facebook.com/"></a>
			<input 
				placeholder="FB" 
				type="text" 
				name="Data[User][UF_FB]" 
				value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_FB"]);?>"/>
		</div>
		<div class="add-user-socialnetwork-g">
			<a target="_blank" href="https://plus.google.com/"></a>
			<input 
				placeholder="G+" 
				type="text" 
				name="Data[User][UF_G_PLUS]" 
				value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_G_PLUS"]);?>"/>
		</div>
		<div class="add-user-socialnetwork-vk">
			<a target="_blank" href="https://vk.com/"></a>
			<input 
				placeholder="VK" 
				type="text" 
				name="Data[User][UF_VK]" 
				value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_VK"]);?>"/>
		</div>
	</div>
	<div class="add-user-submit">
		<input type="submit" id="SendForm" value=""/>
	</div>
	<div class="add-user-iagree">
			<input 
				<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_IAGREE"]) == 1 ? " checked=\"checked\" " : "";?>
				type="checkbox" 
				name="Data[User][UF_IAGREE]" 
				onchange="ActiveButtonSend(this);"
				value="1"/>
			<a target="_blank" href="/amplifiers/iagree.php">СОГЛАШЕНИЕ</a>
			<span> на обработку персональной информации</span>
	</div>
	<div class="add-user-iagree">
		<input 
			<?=htmlspecialcharsbx($_POST["Data"]["User"]["INFO"]) == 1 ? " checked=\"checked\" " : "";?>
			type="checkbox" 
			name="Data[User][INFO]"
			onclick="IsInfoContact()"
			value="1"/>
		<a href="javascrip:void(0)">Инфо контакт</a>
	</div>
	<input 
		type="hidden" 
		name="Data[User][UF_LATITUDE]" 
		value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_LATITUDE"]);?>"/>
	<input 
		type="hidden" 
		name="Data[User][UF_LONGITUDE]" 
		value="<?=htmlspecialcharsbx($_POST["Data"]["User"]["UF_LONGITUDE"]);?>"/>
</form>
<script type="text/javascript">
	var InfoContact = <?=htmlspecialcharsbx($_POST["Data"]["User"]["INFO"]) == 1 ? "true" : "false";?>;
	$(document).ready(function(){
		/*$("input[name='Data[User][PERSONAL_BIRTHDAY]']").datetimepicker({
			timepicker:false,
			format:"d.m.Y",
			lang:"ru"
		});*/
		$("input[name='Data[User][UF_DO_YOU_SMOKE]']").bind("change",function(){ChangeBrend($(this));});
		ChangeBrend($("input[name='Data[User][UF_DO_YOU_SMOKE]']"));
		if(navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(function(position) {
	            $("input[name='Data[User][UF_LATITUDE]']").val(position.coords.latitude);
				$("input[name='Data[User][UF_LONGITUDE]']").val(position.coords.longitude);
			});
		}
		
		$("input[name='Data[User][PERSONAL_MOBILE]']").keypress(function(){
			if($(this).val().length == 0){
				$(this).val("8"+$(this).val())
			} else if($(this).val().charAt(0) != "8") {
				$(this).val("8"+$(this).val());
			}
		});
		
		ActiveButtonSend(null);
	});
	
	function ChangeBrend(Obj){
		var Flag = $(Obj).prop("checked") ? false : true;
		$("input[name='Data[User][UF_BRAND_1]'], input[name='Data[User][UF_BRAND_2]']").attr("disabled",Flag);
	}
	
	function IsInfoContact(){
		InfoContact = $("input[name='Data[User][INFO]']").prop("checked") ? true : false;
		if(InfoContact){
			$("#SendForm").show();
		} else {
			ActiveButtonSend();
		}
	}
	
	function ActiveButtonSend(Obj){
		var Flag = false;
		var Email = $("input[name='Data[User][EMAIL]']").val();
		var Mobile = $("input[name='Data[User][PERSONAL_MOBILE]']").val();
		var YouSmoke = $("input[name='Data[User][UF_DO_YOU_SMOKE]']").prop("checked") ? true : false;
		var Age = $("input[name='Data[User][AGE]']").val();
		var Iagree = $("input[name='Data[User][UF_IAGREE]']").prop("checked") ? true : false;
		if(!InfoContact){
			if(Email.length > 0){
				if(YouSmoke){
					if(Age > 17){
						$("input[name='Data[User][UF_YOU_HAVE_18]']").val("1");
						if(Iagree){
							Flag = true;
						}
					}
				}
			}
			
			if(Flag){
				$("#SendForm").show();
			} else {
				$("#SendForm").hide();
			}
		}
	}
	$("#amplifiers_form").submit(function() {
		var newdate = $("#amplifiers_form input[name='Data[User][PERSONAL_BIRTHDAY]']").val();
		var date = new Date(newdate.replace(/(\d+).(\d+).(\d+)/, '$3/$2/$1'));
		var time = date.getTime();
		if(time > 0 && (Date.now() - time) < 567648000000)
			return false;
		else
			return true;
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>