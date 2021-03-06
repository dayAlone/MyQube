<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Главная</title>
	<link rel="stylesheet" href="http://test.zendo.bz/apex-second/css/main.css">
	<link href='https://fonts.googleapis.com/css?family=Jura:400,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>
	<!-- begin l-container  -->
	<div class="l-container">
		<!-- begin b-text  -->
		<div class="b-text">
			<h1 class="b-text__title"><span>Kent Эксплор — это новый продукт от бренда</span> <span>и является самым инновационным в линейке.</span></h1>
			<div class="b-text__img">
				<img src="http://test.zendo.bz/apex-second/img/pack.png" alt="Картинка пачки сигарет">
			</div>
			<span class="b-text__sub">Смола: 6 мг/сиг, Никотин: 0,6 мг/сиг, СО: 7 мг/сиг</span>
			<p>В новом Kent Эксплор используются 
			<span>исключительные сорта табака и фильтрация</span>
			<span>нового поколения <b>Taste+ Nano-Carbon<i>*</i></b></span>
			<span>для обеспечения многогранного вкуса.</span></p>

			<p><span>Продукт представлен в ограниченном количестве</span>
			<span>точек продаж, и у вас есть возможность одним</span>
			<span>из первых приобрести новый Kent Эксплор.</span></p>
		</div>
		<!-- end b-text -->
		<!-- begin b-map  -->
		<div class="b-map" id="js-map">
			
		</div>
		<!-- end b-map -->
		<footer class="b-footer">
			*Тэйст+ Нано-карбон
		</footer>
	</div>
	<!-- end l-container -->
	<!--<script src="https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>-->
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
	<script type="text/javascript">
		var zoomQ = 11;
		//if (window.matchMedia("(max-width:759px)").matches) {
		//	var zoomQ = 11;
		//}
		var iconImageSizeQone = 40;
		var iconImageSizeQtwo = 68;
		if (window.matchMedia("(max-width:759px)").matches) {
			var iconImageSizeQone = 80;
			var iconImageSizeQtwo = 136;
		}

		ymaps.ready(function(){
			var coords = [
							[56.88579077254235,60.615126499999946],
							[56.84072927274209,60.620992499999986],
							[56.838927272723424,60.62135149999996],
							[56.83747477276891,60.615494499999976],
							[56.8366227727601,60.58340649999997],
							[56.83223027277517,60.61445249999998],
							[56.830482272757166,60.63494350000001],
							[56.82971877280975,60.59222849999989],
							[56.82940413544903,60.599670145507794],
							[56.82438027281501,60.6170755],
							[56.79116677289494,60.64280349999995]							
						];

			var myMap = new ymaps.Map('js-map', {
				center: [56.83385062535236,60.60984108209226],
				zoom: zoomQ,
				behaviors: ['drag']
			});

			var myCollection = new ymaps.GeoObjectCollection({}, {
				draggable: false,
				hideIconOnBalloonOpen: false
			});

			var adresses = [
							['«Магнум»,<br> пр-т. Космонавтов, д.4 '],
							['«Магнум»,<br> пр-т. Ленина, д. 69'],
							['«Магнум»,<br> ул. Луначарского, д. 113'],
							['«Винотека Соловьева»,<br> ул. Красноармейская, д. 8'],
							['«Магнум»,<br> пр-т. Ленина, д 5а'],
							['«Винотека Соловьева»,<br> ул. Белинского, д.32'],
							['«Магнум»,<br> ул. Куйбышева, д. 78'],
							['«Винотека Соловьева»,<br> ул. Радищева, д.25'],
							['«Премиальный табачный аутлет» ТРЦ «Гринвич»,<br> ул. 8 марта, д.46.'],
							['«Магнум»,<br> ул. Белинского, д.84'],
							['«Магнум»,<br> ул. Cамолетная, д.1']			
			]

			var MyBalloonContentLayoutClass = ymaps.templateLayoutFactory.createClass(
				'<p>$[properties.description]</p>'
			);

			myMap.controls.add('zoomControl');
			var zIndex = 650;
			for (var i = 0; i < coords.length; i++) {
				zIndex++;
				var placemark = new ymaps.Placemark(coords[i],
				{
					description: adresses[i]
				},
				{
					balloonContentLayout: MyBalloonContentLayoutClass,
					balloonOffset: [40,20],
					iconImageHref: 'http://test.zendo.bz/apex-second/img/mark.png',
			        iconImageSize: [iconImageSizeQone, iconImageSizeQtwo],
			        iconImageOffset: [-20, -68],
			        zIndex: zIndex
				});
				
				myCollection.add(placemark);
			}

			myMap.geoObjects.add(myCollection);

		})
	</script>
</body>
</html>