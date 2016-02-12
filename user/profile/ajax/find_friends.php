<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$myProfile = CUser::GetByID($USER->GetID())->Fetch();
$filter = Array
(
    "ACTIVE"              => "Y",
	"PERSONAL_CITY"		  => $_POST['s_friend_city'],
	"NAME"  => $_POST['s_name']/*,
	"PERSONAL_BIRTHDAY_1" => date("d.m.Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")-$_POST['s_age_from'])),
	"PERSONAL_BIRTHDAY_2" => date("d.m.Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")-$_POST['s_age_to']))*/
);
if(isset($_POST["sex-frend"]))
	$filter['PERSONAL_GENDER']=($_POST["sex-frend"]=="male-frend")?"M":"F";
if($_POST["s_age_from"]!="")
	$filter["PERSONAL_BIRTHDAY_1"] = date("d.m.Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")-intval($_POST['s_age_to'])));
if($_POST["s_age_to"]!="")
	$filter["PERSONAL_BIRTHDAY_2"] = date("d.m.Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")-intval($_POST['s_age_from'])));	
	//echo "<xmp>"; print_r($filter);echo "</xmp>";
$rsUsers = CUser::GetList(($by="name"), ($order="asc"), $filter, Array("nPageSize"=>20)); // выбираем пользователей
$is_filtered = $rsUsers->is_filtered; // отфильтрована ли выборка ?
$rsUsers->NavStart(20); // разбиваем постранично по 50 записей
echo $rsUsers->NavPrint(GetMessage("PAGES")); // печатаем постраничную навигацию
$flag = false;
while($rsUsers->NavNext(true, "f_")) :
	$flag=true;
	if($f_PERSONAL_PHOTO!="")
		$file = CFile::ResizeImageGet($f_PERSONAL_PHOTO, array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
	else $file["src"]="/images/user_photo.png";
	$username = ($f_NAME!="")?($f_NAME.' '.$f_LAST_NAME):$f_LOGIN;
	//$username.= $f_PERSONAL_BIRTHDAY 
	if($f_ID == $myProfile["ID"]) continue;
	?>
	<div style="display: block; width:100%; height:55px; float:left;">
		<div class="comment" id="user-<?=$f_ID?>">
			<div class="avatar">
				<a href="/user/<?=$f_ID?>/profile/">
					<div class="user-photo" style="background-image: url('<?=$file["src"]?>');">
						<div class="opcircl">
							<div class="colorcrcl"></div>
						</div>
					</div>
				</a>
				<div class="status"></div>
			</div>
			<a href="/user/<?=$f_ID?>/profile/">
				<div class="right-text">
					<div class="user-name"><?=$username?></div>
				</div>
			</a>
			<?if(!in_array($f_ID, $myProfile["UF_FRIENDS"])) {?>
				<div class="right-icons">
					<div class="add-right-icons add-or-del-friend add" data-id="<?=$f_ID?>">
						<div class="add-right-icons-icon"></div>
						<div class="add-right-icons-text"></div>
					</div>
					<div class="add-right-icons del" style="display:none;">Приглашение отправлено</div>
				</div>
			<?}?>
		</div>
	</div>

<?endwhile;?>
<?if(!$flag){?>
	<div style="display: block; width:100%; height:55px; float:left;text-align:center; font-size:24px; color:#969696; margin-top:30px;">
			Данных не найдено
	</div>
<?}?>