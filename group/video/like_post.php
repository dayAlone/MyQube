<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	CModule::IncludeModule("iblock");
	$id 	  = str_replace("like_post_","",$_GET["post_id"]);
	$id 	  = intval(str_replace("video_item_","",$id));
	$like	  = intval($_GET["like"]);
	$UID 	  = $USER->GetID();
	$ib_id    = 6;
	
	/*$resObj = CIBlockElement::GetByID($id);
	$item = $resObj->GetNextElement(true, false);*/
	
	/*$propItems = $item->GetProperty("USERS");*/
	if($like)
	{
		$el = new CIBlockElement;
		$PROP = array();
		$PROP['LIKE'] =  Array(
		"n0" => Array(
		"VALUE" => $id,
		"DESCRIPTION" => "")
		);
		$PROP['USER'] =  Array(
		"n0" => Array(
		"VALUE" => $UID,
		"DESCRIPTION" => "")
		);
		$arLoadProductArray = Array(
		  "IBLOCK_SECTION" => false,
		  "IBLOCK_ID" => $ib_id,
		  "PROPERTY_VALUES" => $PROP,
		  "NAME" => "like",
		  );
		$PRODUCT_ID = id_element;
		$res = $el->Add($arLoadProductArray);
		echo "all ok ".$id;
	}
	else
	{
		$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $ib_id, "PROPERTY_LIKE" => $id, "PROPERTY_USER" => $USER->GetID() ));
		$ob = $res->GetNextElement();
		//echo "<xmp>";print_r($ob);echo "</xmp>";
		if($ob)
		{
			$obs=$ob->GetFields();
			$ELEMENT_ID = 	$obs["ID"];	
			CIBlockElement::Delete($ELEMENT_ID);
		}
		echo "all ok ".$id;
	}
	if(isset($_GET["post_id_w"]))
	{
		$id  = intval($_GET["post_id_w"]);
		if($like)
		{
			$el = new CIBlockElement;
			$PROP = array();
			$PROP['LIKE'] =  Array(
			"n0" => Array(
			"VALUE" => $id,
			"DESCRIPTION" => "")
			);
			$PROP['USER'] =  Array(
			"n0" => Array(
			"VALUE" => $UID,
			"DESCRIPTION" => "")
			);
			$arLoadProductArray = Array(
			  "IBLOCK_SECTION" => false,
			  "IBLOCK_ID" => $ib_id,
			  "PROPERTY_VALUES" => $PROP,
			  "NAME" => "like",
			  );
			$PRODUCT_ID = id_element;
			$res = $el->Add($arLoadProductArray);
			echo "<br>all ok 1 ".$id;
		}
		else
		{
			$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $ib_id, "PROPERTY_LIKE" => $id, "PROPERTY_USER" => $USER->GetID() ));
			$ob = $res->GetNextElement();
			//echo "<xmp>";print_r($ob);echo "</xmp>";
			if($ob)
			{
				$obs=$ob->GetFields();
				$ELEMENT_ID = 	$obs["ID"];	
				CIBlockElement::Delete($ELEMENT_ID);
			}
			echo "<br>all ok 1 ".$id;
		}
	}	
?>