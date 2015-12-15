<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
	$(window).load(function(){
		$(".share_count").each(function(){
			$.get(host_url+"/counters.php?url="+$( this ).attr('link'), function( data ) {
				var res = JSON.parse(data);	
				$(".fb_share_count").text(res.fb);
				$(".vk_share_count").text(res.vk);
				$(".g_share_count").text(res.g);
			});
		});
	});
</script>
<div class="b-header-share">
	<button class="b-header-share__button b-header-share__button--google share-click" data-share="http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>" data-nw="Google Plus" data-title="<?=$arParams['PAGE_TITLE']?>" data-image="<?=$arParams['PAGE_IMAGE']?>" title="Google">
		<i class="fa fa-google-plus"></i>
		<span link="<?=urlencode("http://".SITE_SERVER_NAME.$arParams['PAGE_URL'])?>" class= "g_share_count share_count"></span>
	</button>
		
	<button class="b-header-share__button b-header-share__button--vk share-click" data-share="http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>" data-nw="VK" data-title="<?=$arParams['PAGE_TITLE']?>" data-image="<?=$arParams['PAGE_IMAGE']?>" title="ВКонтакте">
		<i class="fa fa-vk"></i>
		<span link="<?=urlencode("http://".SITE_SERVER_NAME.$arParams['PAGE_URL'])?>" class= "vk_share_count share_count"></span>
	</button>
			
	<button class="b-header-share__button b-header-share__button--fb share-click" data-share="http://<?=$_SERVER['SERVER_NAME']?><?=$arParams['PAGE_URL']?>" data-nw="Facebook" data-title="<?=$arParams['PAGE_TITLE']?>" data-image="<?=$arParams['PAGE_IMAGE']?>" title="Facebook">
		<i class="fa fa-facebook"></i>
		<span link="<?=urlencode("http://".SITE_SERVER_NAME.$arParams['PAGE_URL'])?>" class= "fb_share_count share_count"></span>
	</button>
</div>