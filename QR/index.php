<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if(!CSite::InGroup(array(14)) && !$USER->IsAdmin()) {
	if($USER->IsAuthorized())
		LocalRedirect("/");
	else
		LocalRedirect("/?backurl=/QR/");
}
CModule::IncludeModule("iblock");
$NewElement = new CIBlockElement;
$arLoadProductArray_log = Array(
			  "IBLOCK_ID"      => 27,
			  "NAME"           => $USER->GetID() ? $USER->GetID() : 999
			);
$NewElement->Add($arLoadProductArray_log);
$APPLICATION->SetTitle("QR");?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<style>
	body {
		background: #001022;
		color: #fff;
	}
	.main {
		width:350px;
		margin:50px auto;
		font-size:20px;
		text-align: center;
	}
	a {
		display: block;
		padding: 10px 0;
		margin: 10px 0;
		border: 2px solid #fff;
	}
</style>
<?echo "<div class=\"main\">";
	if($_GET["ok"] == "n") {
		echo "<div>".$CODE."</div>";
		echo "<div style=\"color: #888;\">В активации отказано!</div>";
		die();
	}
	if($CODE = $_GET["CODE"]) {
		if($CODE == 2887070) {
			echo "<div>Код верен</div>";
		} else {
			echo "<div>Неверный код</div>";
		}
		/*CModule::IncludeModule("iblock");
		$arSelect = Array("ID", "IBLOCK_ID", "*");
		$arFilter = Array("IBLOCK_ID"=>20, "ACTIVE"=>"Y", "NAME" => $CODE);
		$res = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
		}
		if($arFields["ID"] > 0) {
			$PERFORMANCE = CIBlockElement::GetByID($arProps["PERFORMANCE"]["VALUE"])->GetNext();
			if($PERFORMANCE["ID"] > 0) {
				$PERFORMANCE_PROPS = CIBlockElement::GetProperty(21, $arProps["PERFORMANCE"]["VALUE"], "sort", "asc", array("CODE" => "DATE_FROM"))->GetNext();
				$user = CUser::GetByID($arProps["USER"]["VALUE"])->Fetch();			
				if($_GET["ok"] == "y" && $arProps["USED"]["VALUE"] !== 1) {
					CIBlockElement::SetPropertyValues($arFields["ID"], 20, 1, "USED");
					$arProps["USED"]["VALUE"] = 1;
				}
				echo "<div>".$arFields["NAME"]."</div>";
				echo $arProps["USED"]["VALUE"] ? "<div>Код верный</div>" : "<div>Код не активирован</div>";
				echo "<div style=\"color: #888;\">Привязан к событию ".$PERFORMANCE["NAME"]." (".date("d.m.Y H:i", strtotime($PERFORMANCE_PROPS["VALUE"])).")</div>";
				echo $arProps["USED"]["VALUE"] ? "" : "<div style=\"color: #888;\">".$user["NAME"]." ".$user["LAST_NAME"]."</div>";
				echo $arProps["USED"]["VALUE"] ? "<div>Активирован</div>" : "<div>Доступен для регистрации</div>";
				if(!$arProps["USED"]["VALUE"]) {
					echo "<a href=\"".$APPLICATION->GetCurPageParam("ok=y", array("ok"))."\">Регистрировать</a> ";
					echo "<a href=\"".$APPLICATION->GetCurPageParam("ok=n", array("ok"))."\">Отказать</a>";
				}
			} else {
				echo "<div>".$CODE."</div>";
				echo "<div style=\"color: #888;\">Код не верен</div>";
			}
		} else {
			echo "<div>".$CODE."</div>";
			echo "<div style=\"color: #888;\">Код не верен</div>";
		}*/
	}
echo "</div>";
			
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>