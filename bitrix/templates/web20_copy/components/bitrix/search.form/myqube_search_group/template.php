<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<script>
	$(document).ready(function(){
		$(".search-preform").click(function(){
			$(this).hide();
			$(".search-form").show(300);
			$(".search-form input[type='text']").focus();
		});
	});
</script>
<style>
	.search-preform {
		font-size: 13px;
		font-family: GothamProRegular;	
		color: #898989;	
	}
	.search-preform img {
		vertical-align: sub;
		margin-left: 5px;
		cursor: pointer;
	}
	.search-form {
		position: relative;
		width: 300px !important;
		margin-right: 20px;
		display: none;
	}
	.search-form input[type="text"] {
		background: none;
		border: none;
		color: #898989;
		height: 24px;
		font-size: 13px;
		font-family: GothamProRegular;
		width:100%;
	}
	.search-form input[type="image"] {
		position: absolute;
		top: 12px;
		right: -20px;
	}
</style>
<?$this->setFrameMode(true);?>
<div class="item search-preform">
	Поиск <img src="/images/search_2.png">
</div>
<div class="item search-form">
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<input type="text" name="q" value="" size="" maxlength="50" placeholder="Поиск" />
		<input name="s" type="image" src="/images/search.png" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />
	</form>
</div>