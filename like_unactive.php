<?if($GLOBALS['gl_like_js']==1||!isset($GLOBALS['gl_like_js']))
{?>
	<style>
		.likes-wrap {
			float: left;
			width: 40px;
			overflow:visible;
		}
		.likes-wrap:hover .likes-number{
			/*width:30px;*/
			opacity: 1;
			-webkit-transform: scale(1);
			transform: scale(1);
		}
		a.likes {
			display: block;
			cursor: pointer;
			width: 20px;
			height: 18px;
			background: url(/bitrix/templates/web20/images/like.png);
			background-repeat: no-repeat;
			margin-top: 3px;
			float: left;
			transition: 1s;
			-webkit-transition: 1s;
			margin-right:0px !important;
		}
		 .likes-number {
			white-space: nowrap;
			font-size: 11px;
			width: 10px;
			padding-top: 4px;
			padding-left: 10px;
			height: 30px;
			font-size: 11px;
			float: left;
			/*opacity: 0;*/
			-webkit-transform: scale(0);
			-webkit-transition: 1s;
			transform: scale(1);
			transition: 1s;
			overflow:visible;
		}
		a.likes:hover, a.likes.active {
			background: url(/images/like_active.png) no-repeat;
		}
	</style>
	<script>
	$(function(){
		$("a.likes" ).click(function(event) 
		{
			event.preventDefault();
			$(this).toggleClass( "active" );
			var path = host_url+'<?=$GLOBALS['gl_like_url']?>';
			$.get(path, {<?=$GLOBALS['gl_like_param']?>: $(this).attr('id'),like: Number($( this ).hasClass( "active" ))}, function(data){
			});
			var tmp = Number($( this ).hasClass( "active" ));
			if(tmp==0)tmp=-1;
			$(this).next().html(tmp + parseInt($(this).next().html()));
		});
	});
	</script>
<?}?>
	<div class="likes-wrap">
		<a id="<?=$GLOBALS['gl_like_id']?>" href="#" class="likes <?=($GLOBALS['gl_active']>0)?"active":""?>"></a>
		<div class="likes-number"><?=$GLOBALS['gl_like_numm']?></div>
	</div>