<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
$page_name="contest";

	include($_SERVER["DOCUMENT_ROOT"]."/user/header.php");
			$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/chat/index.php"
			)
		);
	$only_my = 1;
	if($page_name=="contest") {?>
		<style>
			.left-menu {
				float:left;
				width:210px;
				position:relative;
			}
			.left-menu div {
				margin: 30px 0;
				/*margin-left: 45px;*/
			}
			.left-menu a {
				color: #FFFFFF;
				font-size: 12px;
				text-decoration: none;
				text-transform: uppercase;
				padding-bottom: 5px;
			}
			.left-menu a:hover, .left-menu a.selected {
				color: #FFFFFF;
				text-decoration: none;
				border-bottom: 2px solid #00d7ff;
			}
			#content_inner {
				width: 634px !important;
			}
		</style>
		<div class="left-menu">
			<div><a href="?filter=all" <?if($_GET["filter"] !== "my" && $_GET["filter"] !== "archive") echo 'class="selected"';?>>Все</a></div>
			<div><a href="?filter=my" <?if($_GET["filter"] == "my") echo 'class="selected"';?>>Участвую</a></div>
			<div><a href="?filter=archive" <?if($_GET["filter"] == "archive") echo 'class="selected"';?>>Архив</a></div>
		</div>
<?	
	}
	include($_SERVER["DOCUMENT_ROOT"]."/group/contest/ajax_contest.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>