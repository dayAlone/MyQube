<!-- begin b-photos  -->
<div class="l-section b-photos" id="photos">
	<div class="b-section__title">Фото</div>
	<div class="b-photos-wrapper">
		<div class="b-photos-carousel">
			<?
			$res = CIBlockElement::GetList(array("sort"=>"asc"), array("ID" => 9763));
			while($arRes = $res->GetNextElement()) {				
				$i = 0;
				$arItem = $arRes->GetFields();
				$arItem["PROPERTIES"] = $arRes->GetProperties();
				rsort($arItem["PROPERTIES"]["PHOTO"]["VALUE"]);
				//if($USER->GetID() == 2 || $USER->GetID() == 3) {
					foreach($arItem["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) {
						if($i == 0) echo	'<div class="b-photos-carousel__block">';?>
							<a onclick="return false;" href="#testube<?=$arItem["ID"].$key?>" rel="gallery<?=$arItem["ID"]?>" class="b-photos-carousel__link js-fancybox" style="height: auto !important;">					
								<?$image_small = CFile::ResizeImageGet($picture, array("width" => 550, "height" => 470));?>
								<img src="<?=$image_small["src"]?>" alt="Слайд">
							</a>
						<?$i++;
						?><div style="display:none; height: 100%;" id="testube<?=$arItem["ID"].$key?>">
							<img src="<?=CFile::GetPath($picture)?>" alt="Слайд" class="fancybox-image" style="height: auto !important;">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.share", 
								"myqube_uconcept_pics", 
								array(
									"COMPONENT_TEMPLATE" => "myqube_uconcept_pics",
									"HIDE" => "N",
									"HANDLERS" => array(
										0 => "facebook",
										1 => "vk",
										2 => "Google",
									),
									"PAGE_URL" => "/group/1/u_concept/?photo=".$picture,
									"PAGE_TITLE" => "Городской спектакль U_concept / Екатеринбург",
									"PAGE_IMAGE" => "http://myqube.ru".$image_small["src"],
									"SHORTEN_URL_LOGIN" => "",
									"SHORTEN_URL_KEY" => ""
								),
								false
							);?>
						</div><?
						if($i == 2) { echo '</div>'; $i = 0; }
					}
				/*} else {					
					foreach($arItem["PROPERTIES"]["PHOTO"]["VALUE"] as $key => $picture) {
						if($i == 0) echo	'<div class="b-photos-carousel__block">';?>
							<a onclick="return false;" href="<?=CFile::GetPath($picture)?>" rel="gallery<?=$arItem["ID"]?>" class="b-photos-carousel__link js-fancybox" style="height: auto !important;">					
								<?$image_small = CFile::ResizeImageGet($picture, array("width" => 550, "height" => 470));?>
								<img src="<?=$image_small["src"]?>" alt="Слайд">
							</a>
						<?$i++;
						if($i == 2) { echo '</div>'; $i = 0; }
					}
				}*/
			}
			?>
		</div>
	</div>
</div>
<!-- end b-photos -->