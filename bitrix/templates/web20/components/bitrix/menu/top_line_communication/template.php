<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<nav id="nav_1" style="padding-left:100px; position:relative;">
         <div class="mobile-block mobile-menu-ico" id="menu-button"></div>
         <script>
                  $(function(){
                        $("#menu-button").click(function(){
                            console.log($("#nav_left_open").css('left'));
                        
                            if($("#nav_left_open").css('left') == '-170px'){
                                
                               $("#nav_left_open").animate({ left: '0' }, 400);
                                $("div.main").animate({ left: '170' }, 400);                   
                            };
                            if($("#nav_left_open").css('left') == '0px'){
                      
                                $("#nav_left_open").animate({ left: '-170' }, 400);
                                $("div.main").animate({ left: '0' }, 400);
                            };            
                        })
                        })
                  

         
         </script>
	<div class="nav-inner">
		<?if (!empty($arResult)):
		$arr_1 = explode("/",$_SERVER['REQUEST_URI']);
		?>
		<?if($_GET["user"]) $user = $_GET["user"]; else $user = CUser::GetID();?>
		<?foreach($arResult as $arItem):?>
			<?
			$link = str_replace("#group_id#", $arParams["group_id"], $arItem["LINK"]);
			$link = str_replace("#user#", $user, $link);
			$section_1 = str_replace("/","#",$arItem["LINK"]);
			$section = preg_replace("/^#group##group_id##?(\w*)#?$/","$1",$section_1);
			if($section!==""&&in_array($section,$arr_1)||$section==""&&$arr_1[3]=="")$arItem["SELECTED"]=1;
			?>
			<?if($arItem["SELECTED"]):?>
				<div class="item"><a class="selected" href="<?=$link?>"><?=mb_strtoupper($arItem["TEXT"]);?></a></div>
			<?else:?>
				<div class="item"><a href="<?=$link?>"><?=mb_strtoupper($arItem["TEXT"])?></a></div>
			<?endif?>
			
		<?endforeach?>
		<?endif?>
		<?if($arParams["group_id"]) {?>
			<div class="item"><a href="/group/1/"><img src="<?=SITE_TEMPLATE_PATH?>/images/KENT LAB.png" style="vertical-align: middle; height: 13px;"></a></div>
		<?}?>
		<?if($arParams["LAST_LINK"]) {?>
			<div class="item"><a href="<?=$arParams["LAST_LINK"]["LINK"]?>" <?=$arParams["LAST_LINK"]["STYLE"]?>><?=$arParams["LAST_LINK"]["NAME"]?></a></div>
		<?}?>
	</div>
</nav>
<?/*echo "<xmp>";print_r($arResult); echo "</xmp>";*/?>