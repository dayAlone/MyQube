<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
echo "На сегодняшний день у нас зарегистрировалось пользователей: ".CUser::GetCount()."<br>";
$rsUsers = CUser::GetList(($by="id"), ($order="asc"), Array(/*"UF_GROUPS"=>1*/),array("SELECT"=>array(/*"PERSONAL_BIRTHDAY","UF_DO_YOU_SMOKE","UF_YOU_HAVE_18","UF_IAGREE"*/"UF_GROUPS"))); // выбираем пользователей
$is_filtered = $rsUsers->is_filtered; // отфильтрована ли выборка ?
$rsUsers->NavStart(50000); // разбиваем постранично по 50 записей

while($rsUsers->NavNext(true, "f_")) :
   // echo "[".$f_ID."] (".$f_PERSONAL_BIRTHDAY.",".$f_UF_DO_YOU_SMOKE.",".$f_UF_YOU_HAVE_18.",".$f_UF_IAGREE.")"."<br>";	
   echo "[".$f_ID."]";
   //echo "<xmp>"; print_r($f_UF_GROUPS); echo "</xmp>";
   if(!in_array(1,$f_UF_GROUPS))
   {
		$f_UF_GROUPS[]=1;
		echo "<xmp>"; print_r($f_UF_GROUPS); echo "</xmp>";
  // if($f_UF_GROUPS/*!$f_PERSONAL_BIRTHDAY||!$f_UF_DO_YOU_SMOKE||!$f_UF_YOU_HAVE_18||!$f_UF_IAGREE*/)
 //  {
		$User = new CUser;
		$Fields = array("UF_GROUPS" => $f_UF_GROUPS);
		/*$Fields = array("UF_YOU_HAVE_18" => 1, "UF_DO_YOU_SMOKE" => 1, "UF_IAGREE" => 1);
		if(!$f_PERSONAL_BIRTHDAY)
			$Fields["PERSONAL_BIRTHDAY"]='11.05.1990';*/
		$res = $User->Update($f_ID,$Fields);
		echo "updated<br>";
	}
endwhile;

$rsUsers = CUser::GetList(
    ($by="id"), ($order="asc"),
    array("UF_GROUPS"=>1),
    array(
        'NAV_PARAMS' => array(
            "nTopCount" => 0
        )
    )
);
echo "???".$rsUsers->NavRecordCount."!!!!";
?>