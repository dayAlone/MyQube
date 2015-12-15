<?
CModule::IncludeModule("iblock");
$iblock_id = 1;
$user_id = $USER->GetID();
if(!empty($_POST["project_vote"])) {
	$arFields = array(
		"IBLOCK_ID" => 22,
		"NAME" => "Голос",
		"PROPERTY_VALUES" => array(
			"VOTE" => $_POST["project_vote"],
			"USER" => $user_id
		)
	);
	$oElement = new CIBlockElement();
	$idElement = $oElement->Add($arFields, false, false, true);
	$countVotes = CIBlockElement::GetProperty($iblock_id, $_POST["project_vote"], array("sort" => "asc"), Array("CODE"=>"VOTES"))->Fetch();
	$userFields = $USER->GetByID($user_id)->Fetch();
	if($userFields["UF_AMBASSADOR"]) {
		$countVotes["VALUE"]+100;
	} else {
		$countVotes["VALUE"]++;
	}
	CIBlockElement::SetPropertyValues($_POST["project_vote"], $iblock_id, $countVotes["VALUE"], "VOTES");
}
$group_id = (isset($arGroup["id"]))?$arGroup["id"]:$_GET["GROUP_ID"];
$arPosts = array();
$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "PROPERTY_SOCIAL_GROUP_ID" => $group_id, "PROPERTY_ANC_TYPE" => 22, "PROPERTY_U_CONCEPT" => 33);
$res = CIBlockElement::GetList(array("PROPERTY_VOTES" => "DESC"), $arFilter, false, Array("nPageSize" => 3));
while($arItemObj = $res->GetNextElement()) {
	$arItem = $arItemObj->GetFields();
	$arItem["PROPERTIES"] = $arItemObj->GetProperties();
	$arPosts[] = $arItem;
}
?>

<script>
	$(document).ready(function(){
		var modalAgreement = '<div class="b-modal-agreement">'+
			'<p class="b-modal-agreement__text">Спасибо! После подтверждения выбора Вы не сможете поменять свое мнение!</p>'+
			'<div class="text-center"><a href="#" class="b-modal-agreement__agree" title="Согласен"><img src="/images/uconcept/gul.svg" alt="Cогласен" /></a>'+
			'<a href="#" class="b-modal-agreement__disagree" title="Несогласен"><img src="/images/uconcept/bigclose.png" alt="Несогласен" /></a></div>'+
		'</div>';
		var modalWarning = '<div class="b-modal-agreement">'+
			'<p class="b-modal-agreement__text">Вы уже проголосовали за другой проект! Спасибо!</p>'+
		'</div>';
		$("#projects_votes").submit(function() {
			var resp = $.ajax({
                type: "POST",
                url: "/group/u_concept/vote.php",
                async: false,
                data: { id: $('input[name=project_vote]:checked').val() }
			}).responseText;
			if(resp == 1) {
				$("input:checked").parent().append(modalWarning);
				setTimeout(function(){$('.b-modal-agreement').remove()},2000)
				return false;
			} else {
				$("input:checked").parent().append(modalAgreement);
				return false;
			}
		});
		/*несогласен проголосовать*/
		$(document).on('click', '.b-modal-agreement__disagree', function(e){
			e.preventDefault();
			$(this).parents('.b-modal-agreement').remove();
		})

		/*согласен проголосовать*/
		$(document).on('click', '.b-modal-agreement__agree', function(e){
			e.preventDefault();
			$(this).parents('.b-voting-block').addClass('active');
			$(this).parents('.b-modal-agreement').remove();
					
			data = $("#projects_votes" ).serialize();
			$.ajax({
			  type: "POST",
			  url: "/group/u_concept/vote_submit.php",
			  data: data,
			  dataType: 'json',
			  success: function(data, textStatus, jqXHR)
			  {
				  if(data.success != 0) {
					  $("#p_"+data.id+" .b-counter").text(data.vote);
				  }
			 }
			})	
		})
	});
</script>
<!-- begin b-projects  -->
<?//if($_GET["test"]==2) {?>
<style>
@media (max-width: 640px) {
  .b-section__title {
    text-align: left;
    font-size: 30px;
  }
}
</style>
<div class="l-section b-authors b-projects b-projects--outcome" id="projects">
	<div class="b-section__title b-section__title--big">итоги голосования</div>
	<div class="l-row l-row--authors">
		<?
		$post[9257] = 20287;
		$post[9256] = 20695;
		$post[9258] = 20904;
		$max_vote = $arPosts[0]["PROPERTIES"]["VOTES"]["VALUE"]+$arPosts[1]["PROPERTIES"]["VOTES"]["VALUE"]+$arPosts[2]["PROPERTIES"]["VOTES"]["VALUE"];
		//$max_vote = max($arPosts[0]["PROPERTIES"]["VOTES"]["VALUE"], $arPosts[1]["PROPERTIES"]["VOTES"]["VALUE"], $arPosts[2]["PROPERTIES"]["VOTES"]["VALUE"]);
		?>
		<?foreach($arPosts as $key => $val) {?>		
			<div class="l-row__col l-row__col-authors b-authors l-row__col_sw_4" data-vote="<?=$val["ID"]?>" id="p_<?=$val["ID"]?>">
				<div class="b-projects__vote-sum" data-vote-sum="<?=$max_vote?>">
					<p data-vote-one="<?=$val["PROPERTIES"]["VOTES"]["VALUE"]?>"><span><?=$val["PROPERTIES"]["VOTES"]["VALUE"]?> <span>голоса</span></span></p>
				</div>
				<div class="b-authors__title" style="color:#fff;">«<?=$val["NAME"]?>»</div>
				<div class="b-image">
					<img src="<?=CFile::GetPath($val["PREVIEW_PICTURE"])?>" alt="Фото проекта">
				</div>
				<div class="b-authors-text">
					<a href="/group/<?=$group_id?>/post/<?=$post[$val["ID"]]?>/" title="Подробнее" class="b-authors__link">Узнать больше</a>
				</div>
			</div>
		<?}?>
	</div>
</div>
<?/*} elseif($_GET["test"]==1) {?>
<div class="l-section b-authors b-projects b-projects--end-vote" id="projects">
	<div class="b-projects__end-vote">
		<p>голосование <span>остановлено</span></p>
	</div>
	<div class="b-section__title b-section__title--big">спешите голосовать. <span>Осталось всего</span></div>
	<div class="b-projects-timer"></div>
	<br><br>
	<div class="l-row l-row--authors">
		<?
		$post[9257] = 20287;
		$post[9256] = 20695;
		$post[9258] = 20904;
		?>
		<?foreach($arPosts as $key => $val) {?>		
			<div class="l-row__col l-row__col-authors l-row__col_sw_4" data-vote="<?=$val["ID"]?>" id="p_<?=$val["ID"]?>">
				<div class="b-authors__title">«<?=$val["NAME"]?>»</div>
				<div class="b-image">
					<img src="<?=CFile::GetPath($val["PREVIEW_PICTURE"])?>" alt="Фото проекта">
				</div>
				<div class="b-authors-text">
					<a href="/group/<?=$group_id?>/post/<?=$post[$val["ID"]]?>/" title="Подробнее" class="b-authors__link">Узнать больше</a>
				</div>
			</div>
		<?}?>
	</div>
</div>	
<?} else {?>
<div class="l-section b-authors b-projects" id="projects">
	<div class="b-projects__end-vote">
		<p>голосование <span>остановлено</span></p>
	</div>
	<div class="b-section__title b-section__title--big">спешите голосовать. <span>Осталось всего</span></div>
	<div class="b-projects-timer"></div>
	<div class="l-row l-row--authors">
		<?
		$post[9257] = 20287;
		$post[9256] = 20695;
		$post[9258] = 20904;
		?>
		<?foreach($arPosts as $key => $val) {?>		
			<div class="l-row__col l-row__col-authors l-row__col_sw_4" data-vote="<?=$val["ID"]?>" id="p_<?=$val["ID"]?>">
				<div class="b-authors__title">«<?=$val["NAME"]?>»</div>
				<div class="b-image">
					<img src="<?=CFile::GetPath($val["PREVIEW_PICTURE"])?>" alt="Фото проекта">
					<!--span class="b-counter"><?=$val["PROPERTIES"]["VOTES"]["VALUE"]?></span-->
				</div>
				<div class="b-authors-text">
					 
					<!--p><?=$val["PREVIEW_TEXT"]?></p-->
					<a href="/group/<?=$group_id?>/post/<?=$post[$val["ID"]]?>/" title="Подробнее" class="b-authors__link">Узнать больше</a>
				</div>
			</div>
		<?}?>
	</div>
	<form class="l-row l-row--authors b-voting" method="post" id="projects_votes">
		<?foreach($arPosts as $key => $val) {?>		
			<div class="l-row__col l-row__col-authors l-row__col_sw_4 b-voting-block" id="<?=$val["ID"]?>">
				<input type="radio" name="project_vote" id="project_<?=$val["ID"]?>" value="<?=$val["ID"]?>">
				<label for="project_<?=$val["ID"]?>"><span></span><i>«<?=$val["NAME"]?>»</i></label>
			</div>
		<?}?>
		<div class="text-center">
			<button type="submit" class="b-voting__button">Оставить свой голос</button>
		</div>
	</form>
</div>
<?}*/?>
	<script src="/js/jquery.countdown.js"></script>
	<script src="/js/jquery.countdown-ru.js"></script>
	<script>
		var date = new Date(); 
		date = new Date(date.getFullYear(), 11 - 1, 27 ,24-1 ,40-1); 
		$('.b-projects-timer').countdown({until: date, format: 'DHM', padZeroes: true, timezone: +6}); 
	</script>
<!-- end b-authors -->