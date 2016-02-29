	<div class='footer'>
		<? include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php') ?>
	</div>
	</div>
	<?$APPLICATION->ShowViewContent('footer');?>
	<? if($USER->GetID() > 0 && !$USER->GetByID($USER->GetID())->Fetch()["UF_AUTH_SOCNET"]) { ?>
		<div id="connectSocial" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content center">
				<a data-dismiss="modal" href="#" class="modal__close"><?=svg('close')?></a>
				<h5 class="l-margin-top">Для удобства последующей авторизации<br/>вы можете привязать к своему аккаунту<br/>социальную сеть</h5>
				<div class='l-padding-bottom center xl-margin-top'>
					<?$APPLICATION->IncludeComponent(
						"bitrix:system.auth.form",
						"connect",
						array(
							"REGISTER_URL" => "/club/group/search/",
							"PROFILE_URL" => "/user/profile/",
							"FORGOT_PASSWORD_URL" => "",
							"SHOW_ERRORS" => "Y",
							"ONLY_SOCNET" => "Y",
							"BACKURL" => $backurl
						),
						false
					);?>
				</div>
			</div>
		  </div>
		</div>
	<?}?>
	<!-- Yandex.Metrika counter -->
		<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter34335385 = new Ya.Metrika({ id:34335385, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/34335385" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</body>
</html>
