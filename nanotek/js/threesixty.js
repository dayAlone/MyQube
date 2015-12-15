function ThreeSixty(config) {
	var self = this;
	var ready = false;
	var dragging = false;
	var pointerStartPosX = 0;
	var pointerEndPosX = 0;
	var pointerDistance = 0;

	var monitorStartTime = 0;
	var monitorInt = 10;
	var ticker = 0;
	var speedMultiplier = config.speed;
	var spinner;

	var defaultFrame = config.startFrame;
	var totalFrames = config.frames;
	var currentFrame = config.startFrame;
	var frames = [];
	var endFrame = 0;
	var loadedImages = 0;

	var $document = $(document);
	var $container = $(config.container);
	var $images = $(config.images);
	var $spinner = $(config.spinner);

	this.reveal = function(idx) {
		if (ready) {
			endFrame = idx;
			refresh();
		}
	};

	this.reset = function() {
		if (ready) {
			endFrame = defaultFrame;
			refresh();
		}
	};
	
	function addSpinner () {
		spinner = new CanvasLoader(config.spinnerId);
		spinner.setShape("spiral");
		spinner.setDiameter(90);
		spinner.setDensity(90);
		spinner.setRange(1);
		spinner.setSpeed(4);
		spinner.setColor("#ffffff");
		spinner.show();
		$spinner.fadeIn("slow");
	};
	
	function loadImage() {
		var li = document.createElement("li");
		var imageName = config.imagePath + ("0000" + loadedImages).slice(-4) + ".png";
		var image = $('<img>').attr('src', imageName).addClass("previous-image").appendTo(li);
		frames.push(image);
		$images.append(li);

		$(image).load(function() {
			imageLoaded();
		});
	};
	
	function imageLoaded() {
		loadedImages++;
		$spinner.find('span').text(Math.floor(loadedImages / totalFrames * 100) + "%");
		if (loadedImages == totalFrames) {
			frames[ getNormalizedCurrentFrame(currentFrame) ].removeClass("previous-image").addClass("current-image");
			$spinner.fadeOut("slow", function(){
				spinner.hide();
				showThreesixty();
			});
		} else {
			loadImage();
		}
	};
	
	function showThreesixty () {
		$images.fadeIn("slow");
		ready = true;
		endFrame = currentFrame;
		refresh();
	};

	addSpinner();
	loadImage();
	
	function render () {
		if (currentFrame !== endFrame) {
			var frameEasing = endFrame < currentFrame ? Math.floor((endFrame - currentFrame) * 0.1) : Math.ceil((endFrame - currentFrame) * 0.1);
			var nextFrame = currentFrame + frameEasing;
			if (!config.limited || ((nextFrame <= totalFrames) && (nextFrame > 0))) {
				hidePreviousFrame();
				currentFrame += frameEasing;
				showCurrentFrame();
			}
		} else {
			window.clearInterval(ticker);
			ticker = 0;
		}
	};
	
	function refresh () {
		if (ticker === 0) {
			ticker = window.setInterval(render, Math.round(1000 / 60));
		}
	};
	
	function hidePreviousFrame() {
		frames[getNormalizedCurrentFrame()].removeClass("current-image").addClass("previous-image");
	};
	
	function showCurrentFrame() {
		frames[getNormalizedCurrentFrame()].removeClass("previous-image").addClass("current-image");
	};

	function getNormalizedCurrentFrame() {
		var c = -Math.ceil(currentFrame % totalFrames);
		if (c < 0) {
			c += (totalFrames - 1);
		}
		return c;
	};

	function getPointerEvent(event) {
		return event.originalEvent.targetTouches ? event.originalEvent.targetTouches[0] : event;
	};

	$container.on("mousedown", function (event) {
		event.preventDefault();
		var isVertical = config.direction == 'vertical';
		pointerStartPosX = (isVertical ? getPointerEvent(event).pageY : getPointerEvent(event).pageX);
		dragging = true;
	});
	
	$document.on("mouseup", function (event){
		event.preventDefault();
		dragging = false;
		// if (config.limited) {
		// 	endFrame = defaultFrame;
		// } else if (currentFrame < 0) {
		// 	endFrame = Math.round(currentFrame/totalFrames) * totalFrames - defaultFrame;
		// } else {
		// 	endFrame = Math.round(currentFrame/totalFrames) * totalFrames + defaultFrame;
		// }
		// refresh();
	});
	
	$document.on("mousemove", function (event){
		event.preventDefault();
		trackPointer(event);
	});
	
	$container.on("touchstart", function (event) {
		//event.preventDefault();
		var isVertical = config.direction == 'vertical';
		pointerStartPosX = (isVertical ? getPointerEvent(event).pageY : getPointerEvent(event).pageX);
		dragging = true;
	});
	
	$container.on("touchmove", function (event) {
		event.preventDefault();
		trackPointer(event);
	});
	
	$container.on("touchend", function (event) {
		//event.preventDefault();
		dragging = false;
		// if (config.limited) {
		// 	endFrame = defaultFrame;
		// } else if (currentFrame < 0) {
		// 	endFrame = Math.round(currentFrame/totalFrames) * totalFrames - defaultFrame;
		// } else {
		// 	endFrame = Math.round(currentFrame/totalFrames) * totalFrames + defaultFrame;
		// }
		// refresh();
	});
	
	function trackPointer(event) {
		var userDragging = ready && dragging ? true : false;
		var isVertical = config.direction == 'vertical';
		if (userDragging) {
			pointerEndPosX = (isVertical ? getPointerEvent(event).pageY : getPointerEvent(event).pageX);

			if (monitorStartTime < new Date().getTime() - monitorInt) {
				pointerDistance = pointerEndPosX - pointerStartPosX;
				// if (pointerDistance > 0) {
				// 	endFrame = currentFrame + Math.ceil((totalFrames - 1) * speedMultiplier * (pointerDistance / $container.width()));	
				// } else {
				// 	endFrame = currentFrame + Math.floor((totalFrames - 1) * speedMultiplier * (pointerDistance / $container.width()));
				// }
				var measure = (isVertical ? $container.height() : $container.width());
				var diff = Math.round((totalFrames - 1) * speedMultiplier * (pointerDistance / measure));
				if (diff != 0) {
					endFrame = currentFrame + diff;
					refresh();
					monitorStartTime = new Date().getTime();
					pointerStartPosX = (isVertical ? getPointerEvent(event).pageY : getPointerEvent(event).pageX);
				}
			}
		}
	};

	return self;
};