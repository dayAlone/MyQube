<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	global $USER;
	
	$targ_w = $targ_h = 85;
	$jpeg_quality = 90;
	//echo "<xmp>";print_r($_POST);echo "</xmp>";
	//$data = imagecreatefromstring(base64_decode($_POST["img"]));
	$data = $_POST["img"];
	list($type, $data) = explode(';', $data);
	//echo $type."!!!";
	$ext='jpg';
	if(strpos($type,'png')!==FALSE)
	    $ext='png';
	else if(strpos($type,'gif')!==FALSE)
	    $ext='gif';
	else $ext='jpg';
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/ava/".$USER->GetID().".".$ext,$data);
	$src = $_SERVER["DOCUMENT_ROOT"]."/upload/ava/".$USER->GetID().".".$ext;
	$src_1 = $_SERVER["DOCUMENT_ROOT"]."/upload/ava/".$USER->GetID()."_1.jpg";
	echo $src;
	
	list($width, $height, $image_type) = getimagesize($src);
	//$data = base64_decode($_POST["img"]);
	$k=1;
	$x=$_POST['x'];
	$y=$_POST['y'];
	$w=$_POST['w'];
	$h=$_POST['h'];
	if($width>500)
		$k=$width/500;
		
	if($ext=='jpg')
	    $img_r = imagecreatefromjpeg($src);
	else if($ext=='png')
	    $img_r = imagecreatefrompng($src);
	else if($ext =='gif')
	    $img_r = imagecreatefromgif($src);
	else
	    $img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	echo $k;
	imagecopyresampled($dst_r,$img_r,0,0,$x*$k,$y*$k,$targ_w,$targ_h,$w*$k,$h*$k);
	
	imagejpeg($dst_r, $src_1, 100);

	$arFile = CFile::MakeFileArray($src_1);

	$user = new CUser;
	$fields = Array( 
		"PERSONAL_PHOTO" => $arFile, 
	); 
	$user->Update($USER->GetID(), $fields);
?>