<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
	$.ajax({
			url: host_url+"/communication/ajax/count.php",
			method: 'GET',
		}).done(function(data){
			var n_new_m=parseInt(data);
			if(n_new_m>0){
				$("#new_messages_count").html(n_new_m);
				$("#new_messages_count").show();
			}
		});	
</script>
<nav id="nav_left_open" >
	<a class="show_full_nav" href="#"></a>
	<?
	$i=1;
	//echo"<xmp>"; print_r($arResult);echo"</xmp>";
	if (!empty($arResult)):
		foreach($arResult as $arItem): if((($arItem["LINK"] == "/calendar/"||$arItem["LINK"] == "/user/news/")/*||$arItem["LINK"] == "/group/1/"*/) && !$USER->IsAdmin()) continue;?>
			<? $st = str_replace(Array("/","?","=yes","1","2","3","4","5","6","7","8","9","0"),"",$arItem["LINK"]); ?>
			<a  href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>" class="nav_item<?if ($arItem["SELECTED"]):?> item-selected<?endif?><?if ($i==1):?> nav_item_1<?endif?>"><span class="icon_<?=$arItem["PARAMS"]["href"] == "В группу" ? "group" : $st;?>"><?if($st=="communication"){?><div id="new_messages_count"></div><?}?></span>&nbsp;<span class="nav_text"><?=(isset($arItem["PARAMS"]["href"]))?mb_strtoupper($arItem["PARAMS"]["href"]):mb_strtoupper($arItem["TEXT"])?></span></a>
		<?
		$i++;
		endforeach;
	endif;
	?>
</nav>