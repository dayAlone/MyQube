<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
$page_name="photo";

include($_SERVER["DOCUMENT_ROOT"]."/group/header.php");
?>
<link type="text/css" rel="stylesheet" href="/css/events_detail.css">
<script>
	$("a.likes" ).click(function() {
		$( this ).toggleClass( "active" );
		var path = host_url+"/group/photo/like_post.php";
		$.get(path, {post_id: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
		});
	});
</script>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>