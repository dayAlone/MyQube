(function() {

	var animationMultiplier = 2;

	var applyBlur = function(element, from, to, duration, complete) {
		$({ blurRadius: from }).animate({ blurRadius: to }, {
	        duration: duration,
	        easing: 'swing',
	        step: function() {
	            element.css({
	                "-webkit-filter": "blur("+this.blurRadius+"px)",
	                "filter": "blur("+this.blurRadius+"px)"
	            });
	        },
	        complete: complete
	    });
	};

	var pages = $('.page');
	var container = $('#container');

	// page 0
	var homeHeader1 = pages.eq(0).find('.header .bold');
	var homeHeaders2 = pages.eq(0).find('.header .home-header-line-2');
	var homePacks = pages.eq(0).find('.content-nano img');
	var homePackLinks = pages.eq(0).find('.footer .home-pack-link');
	var homeSidelink = pages.eq(0).find('.footer .sidelink');
	var homeBtn = pages.eq(0).find('.home-btn');
	// info-nanotek
	var infoNanotekHeader1 = pages.eq(1).find('.header .bold');
	var infoNanotekHeader2 = pages.eq(1).find('.header .home-header-line-2');
	var infoNanotekPack = pages.eq(1).find('.content-nano .info-pack');
	var infoNanotekListItems = pages.eq(1).find('.info-list .info-list-item-wrapper');
	var infoNanotekListImgs = pages.eq(1).find('.info-list .info-list-item-wrapper .info-list-item-img');
	var infoNanotekHomeBtn = pages.eq(1).find('.home-btn');
	var infoNanotekNextBtn = pages.eq(1).find('.next-btn');
	var infoNanotekListComment = pages.eq(1).find('.info-list .info-list-comment');
	// info-hd
	var infoHdHeader1 = pages.eq(2).find('.header .bold');
	var infoHdPack = pages.eq(2).find('.content-nano .info-pack');
	var infoHdListItems = pages.eq(2).find('.info-list .info-list-item-wrapper');
	var infoHdListImgs = pages.eq(2).find('.info-list .info-list-item-wrapper .info-list-item-img');
	var infoHdHomeBtn = pages.eq(2).find('.home-btn');
	var infoHdNextBtn = pages.eq(2).find('.next-btn');
	var infoHdListComment = pages.eq(2).find('.info-list .info-list-comment');
	// line-nanotek
	var lineNanotekHeader1 = pages.eq(3).find('.header .bold');
	var lineNanotekPacks = pages.eq(3).find('.content-nano .line-packs');
	var lineNanotekHomeBtn = pages.eq(3).find('.home-btn');
	var lineNanotekPrevBtn = pages.eq(3).find('.prev-btn');
	// line-hd
	var lineHdHeader1 = pages.eq(4).find('.header .bold');
	var lineHdPacks = pages.eq(4).find('.content-nano .line-packs');
	var lineHdHomeBtn = pages.eq(4).find('.home-btn');
	var lineHdPrevBtn = pages.eq(4).find('.prev-btn');
	// line-iswitch
	var lineiSwitchHeader1 = pages.eq(5).find('.header .bold');
	var lineiSwitchPacks = pages.eq(5).find('.content-nano .line-packs');
	var lineiSwitchHomeBtn = pages.eq(5).find('.home-btn');
	var lineiSwitchPrevBtn = pages.eq(5).find('.prev-btn');
	// line-hdi
	var lineHdiHeader1 = pages.eq(6).find('.header .bold');
	var lineHdiPacks = pages.eq(6).find('.content-nano .line-packs');
	var lineHdiHomeBtn = pages.eq(6).find('.home-btn');
	var lineHdiPrevBtn = pages.eq(6).find('.prev-btn');
	// line-hds
	var lineHdsHeader1 = pages.eq(7).find('.header .bold');
	var lineHdsPacks = pages.eq(7).find('.content-nano .line-packs');
	var lineHdsHomeBtn = pages.eq(7).find('.home-btn');
	var lineHdsPrevBtn = pages.eq(7).find('.prev-btn');
	// series-line
	var lineSeriesHeader1 = pages.eq(8).find('.header .bold');
	var lineSeriesPacks = pages.eq(8).find('.content-nano .line-packs');
	var lineSeriesPackImgs = pages.eq(8).find('.content-nano .line-packs img');
	var lineSeriesPackBtns = pages.eq(8).find('.content-nano .line-packs a');
	var lineSeriesHomeBtn = pages.eq(8).find('.home-btn');
	var lineSeriesPrevBtn = pages.eq(8).find('.prev-btn');
	var preSeriesPage = 0;
	var hoveredPage = 0;

	var homePageTransformed = false;

	$('#home-show-pack-2').on('click', function(e) {
		e.preventDefault();
		transformPage1();
	});

	$('.home-btn').on('click', function(e) {
		e.preventDefault();
		container.animate({ opacity: 0 }, 350*animationMultiplier, function() {
			container.css({ 'background-image': "url('/nanotek/img/background.jpg')" });
			pages.filter('.blurred').each(function(index, value) {
				unblurPageHard(pages.index($(value)));
			});
			pages.css({ opacity: 1 });
			hdRotatePackModel.reset();
			nanotekRotatePackModel.reset();
		})
		
		setTimeout(showHomePage, 400*animationMultiplier);
	});

	homePackLinks.eq(0).on('click', function(e) {
		e.preventDefault();
		hideHomePage(prepareNanotekInfo, showNanotekInfo);
	});

	homePacks.eq(1).on('click', function(e) {
		e.preventDefault();
		hideHomePage(prepareNanotekInfo, showNanotekInfo);
	});

	homePackLinks.eq(1).on('click', function(e) {
		e.preventDefault();
		hideHomePage(prepareHdInfo, showHdInfo);
	});

	homePacks.eq(2).on('click', function(e) {
		e.preventDefault();
		hideHomePage(prepareHdInfo, showHdInfo);
	});

	infoNanotekPack.find('a').on('click', function(e) {
		e.preventDefault();
		hoveredPage = 1;
		blurPageHard(1, true);
		showNanotekLine();
	});

	infoHdPack.find('a').on('click', function(e) {
		e.preventDefault();
		hoveredPage = 2;
		blurPageHard(2, true);
		showHdLine();
	});

	infoNanotekNextBtn.on('click', function(e) {
		e.preventDefault();
		preSeriesPage = 1;
		hideNanotekInfo(function() {
			
		});
		showSeriesLine();
	});

	infoHdNextBtn.on('click', function(e) {
		e.preventDefault();
		preSeriesPage = 2;
		hideHdInfo(function() {

		});
		showSeriesLine();
	});

	lineSeriesPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideSeriesLine(function() {
			switch (preSeriesPage) {
				case 1: {
					infoNanotekNextBtn.hide().css({ 'right': '-75px' }).show().animate({ 'right': '36px' }, 500*animationMultiplier);
					break;
				}
				case 2: {
					infoHdNextBtn.hide().css({ 'right': '-75px' }).show().animate({ 'right': '36px' }, 500*animationMultiplier);
					break;
				}
			}
		});
		pages.eq(preSeriesPage).addClass('active');
	});

	lineSeriesPackBtns.eq(0).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdLine();
	});

	lineSeriesPackImgs.eq(0).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdLine();
	});

	lineSeriesPackBtns.eq(1).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showNanotekLine();
	});

	lineSeriesPackImgs.eq(1).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showNanotekLine();
	});

	lineSeriesPackBtns.eq(2).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showiSwitchLine();
	});

	lineSeriesPackImgs.eq(2).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showiSwitchLine();
	});

	lineSeriesPackBtns.eq(3).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdiLine();
	});

	lineSeriesPackImgs.eq(3).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdiLine();
	});

	lineSeriesPackBtns.eq(4).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdsLine();
	});

	lineSeriesPackImgs.eq(4).on('click', function(e) {
		e.preventDefault();
		hoveredPage = 8;
		blurPageHard(8, true);
		showHdsLine();
	});

	lineHdPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideHdLine(function() {
			if (hoveredPage != 8) {
				lineHdPrevBtn.fadeOut(400*animationMultiplier);
			}
			unblurPageHard(hoveredPage);
		});
	});
	
	lineNanotekPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideNanotekLine(function() {
			if (hoveredPage != 8) {
				lineNanotekPrevBtn.fadeOut(400*animationMultiplier);
			}
			unblurPageHard(hoveredPage);
		});
	});

	lineiSwitchPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideiSwitchLine(function() {
			unblurPageHard(hoveredPage);
		});
	});

	lineHdiPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideHdiLine(function() {
			unblurPageHard(hoveredPage);
		});
	});

	lineHdsPrevBtn.on('click', function(e) {
		e.preventDefault();
		hideHdsLine(function() {
			unblurPageHard(hoveredPage);
		});
	});

	var blurPage = function(idx, hideHome, callback) {
		if (hideHome) {
			pages.eq(idx).find('.home-btn').hide();
		}
		pages.eq(idx).find('.next-btn, .prev-btn').hide();
		pages.eq(idx).addClass('blurred');
		var wrapper = pages.eq(idx).find('.page-wrapper')
		applyBlur(wrapper, 0, 40, 700*animationMultiplier, function() {
			if (callback) {
				callback();
			}
		});
	};

	var blurPageHard = function(idx, hideHome, callback) {
		if (hideHome) {
			pages.eq(idx).find('.home-btn').hide();
		}
		pages.eq(idx).find('.next-btn, .prev-btn').hide();
		pages.eq(idx).addClass('blurred');
		pages.eq(idx).find('.page-wrapper').fadeOut(700*animationMultiplier);
		pages.eq(idx).find('.overblur').fadeIn(700*animationMultiplier, function() {
			if (callback) {
				callback();
			}
		});
	};

	var unblurPage = function(idx) {
		var wrapper = pages.eq(idx).find('.page-wrapper');
		pages.eq(idx).removeClass('blurred');
		applyBlur(wrapper, 40, 0, 700*animationMultiplier, function() {
			pages.eq(idx).find('.home-btn, .next-btn, .prev-btn').show();
		});
	};

	var unblurPageHard = function(idx) {
		var wrapper = pages.eq(idx).find('.page-wrapper');
		pages.eq(idx).removeClass('blurred');
		pages.eq(idx).find('.page-wrapper').fadeIn(700*animationMultiplier);
		pages.eq(idx).find('.overblur').fadeOut(700*animationMultiplier);
		pages.eq(idx).find('.home-btn, .next-btn, .prev-btn').show();
	};

	var showHomePage = function() {
		homePageTransformed = false;
		container.css({ opacity: 1 });
		pages.removeClass('active').eq(0).addClass('active');
		homeBtn.hide().css({ 'left': '-75px' });
		homeHeader1.hide();
		homeHeaders2.hide();
		homePacks.hide().eq(1).css({ 'marginRight': '-133px' });
		homePacks.eq(2).css({ 'marginLeft': '-160px' });
		homePackLinks.hide().css({ 'top': '100px' });
		homePackLinks.eq(0).css({ 'marginRight': '-125px' });
		homeSidelink.hide().css({ 'top': '100px' });
		container.css({ 'background-position-x': '-250px' }).hide().fadeIn(700*animationMultiplier);
		homePacks.eq(0).show().delay(300*animationMultiplier).fadeOut(1200*animationMultiplier);
		homePacks.eq(1).delay(300*animationMultiplier).fadeIn(1500*animationMultiplier, function() { homePacks.eq(0).hide(); });
		homeHeader1.css({ 'paddingTop': 0 }).delay(1000*animationMultiplier).animate({ 'paddingTop': '36px', 'opacity': 'toggle' }, 700*animationMultiplier);
		homeHeaders2.eq(0).delay(1500*animationMultiplier).fadeIn(700*animationMultiplier);
		homePackLinks.eq(0).delay(2000*animationMultiplier).show().animate({ 'top': '0px' }, 700*animationMultiplier);
		homeSidelink.delay(2500*animationMultiplier).show().animate({ 'top': '0px' }, 300*animationMultiplier);
	};

	var hideHomePage = function(prepare, callback) {
		prepare();
		pages.eq(0).find('.page-wrapper').css({ opacity: 0 });
		callback();
		pages.eq(0).find('.page-wrapper').css({ opacity: 1 });
	};

	var transformPage1 = function() {
		homePageTransformed = true;
		container.animate({ 'background-position-x': '-525px' }, 500*animationMultiplier);
		homeBtn.show().animate({ 'left': '36px' }, 500*animationMultiplier);
		homeHeaders2.fadeOut(300*animationMultiplier);
		homeSidelink.fadeOut(300*animationMultiplier);
		homeHeaders2.eq(1).delay(500*animationMultiplier).fadeIn(700*animationMultiplier);
		homePacks.eq(1).animate({ 'marginRight': '103px' }, 500*animationMultiplier);
		homePacks.eq(2).show().animate({ 'marginLeft': '53px' }, 500*animationMultiplier);
		homePackLinks.eq(0).animate({ 'marginRight': '116px' }, 500*animationMultiplier);
		homePackLinks.eq(1).show().animate({ 'top': '0px' }, 300*animationMultiplier);
	};

	var prepareNanotekInfo = function() {
		container.css({ 'background-image': "url('img/background.2.jpg')" });
		if (!homePageTransformed) {
			infoNanotekPack.css({ 'left': '446px' }).animate({ 'left': '150px'}, 500*animationMultiplier);
			container.animate({ 'background-position-x': '-575px' }, 500*animationMultiplier);
		}
		infoNanotekHeader1.hide();
		infoNanotekHeader2.hide();
		infoNanotekListItems.hide();
		infoNanotekListComment.hide();
		infoNanotekNextBtn.hide();
		pages.eq(1).addClass('active');
	};

	var showNanotekInfo = function() {
		pages.removeClass('active').eq(1).addClass('active');
		infoNanotekHeader1.css({ 'paddingTop': 0 }).delay(1000*animationMultiplier).animate({ 'paddingTop': '36px', 'opacity': 'toggle' }, 700*animationMultiplier);
		infoNanotekHeader2.hide().delay(1500*animationMultiplier).fadeIn(700*animationMultiplier);
		infoNanotekListComment.hide().delay(1800*animationMultiplier).fadeIn(1200*animationMultiplier);
		infoNanotekNextBtn.hide().css({ 'right': '-75px' }).show().animate({ 'right': '36px' }, 500*animationMultiplier);
		infoNanotekListItems.eq(0).delay(1800*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
		infoNanotekListItems.eq(1).delay(2300*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
		infoNanotekListItems.eq(2).delay(2800*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
	};

	var hideNanotekInfo = function(callback) {
		infoNanotekNextBtn.hide();
		pages.eq(1).find('.page-wrapper').animate({ opacity: 0 }, 500*animationMultiplier, 'swing',  function() {
			pages.eq(1).removeClass('active');
			pages.eq(1).find('.page-wrapper').css({ opacity: 1 });
			callback();
		});
	};

	var showHdInfo = function() {
		pages.removeClass('active').eq(2).addClass('active');
		infoHdHeader1.css({ 'paddingTop': 0 }).delay(1000*animationMultiplier).animate({ 'paddingTop': '36px', 'opacity': 'toggle' }, 700*animationMultiplier);
		infoHdListComment.hide().delay(1800*animationMultiplier).fadeIn(1200*animationMultiplier);
		infoHdNextBtn.hide().css({ 'right': '-75px' }).show().animate({ 'right': '36px' }, 500*animationMultiplier);
		infoHdListItems.eq(0).delay(1800*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
		infoHdListItems.eq(1).delay(2300*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
		infoHdListItems.eq(2).delay(2800*animationMultiplier).animate({ 'opacity': 'toggle' }, 700*animationMultiplier, 'swing');
	};

	var prepareHdInfo = function() {
		container.css({ 'background-image': "url('img/background.2.jpg')" });
		infoHdPack.css({ 'left': '677px' }).animate({ 'left': '170px'}, 500*animationMultiplier);
		container.animate({ 'background-position-x': '-575px' }, 500*animationMultiplier);
		infoHdHeader1.hide();
		infoHdListItems.hide();
		infoHdListComment.hide();
		infoHdNextBtn.hide();
		pages.eq(2).addClass('active');
	};

	var hideHdInfo = function(callback) {
		infoHdNextBtn.hide()
		pages.eq(2).find('.page-wrapper').animate({ opacity: 0 }, 500*animationMultiplier, 'swing',  function() {
			pages.eq(2).removeClass('active');
			pages.eq(2).find('.page-wrapper').css({ opacity: 1 });
			callback();
		});
	};

	var showNanotekLine = function() {
		pages.eq(3).addClass('active');
		lineNanotekHomeBtn.show();
		lineNanotekPrevBtn.show();
		lineNanotekHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineNanotekPacks.css({ 'opacity': '0', 'left': '200px' });
		lineNanotekPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
	};

	var hideNanotekLine = function(callback) {
		lineNanotekHomeBtn.hide();
		lineNanotekPrevBtn.hide();
		pages.eq(3).find('.page-wrapper').animate({ opacity: 0 }, 700*animationMultiplier, 'swing',  function() {
			pages.eq(3).removeClass('active');
			pages.eq(3).find('.page-wrapper').css({ opacity: 1 });
		});
		callback();
	};

	var showHdLine = function() {
		pages.eq(4).addClass('active');
		lineHdHomeBtn.show();
		lineHdPrevBtn.show();
		lineHdHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineHdPacks.css({ 'opacity': '0', 'left': '200px' });
		lineHdPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
	};

	var hideHdLine = function(callback) {
		lineHdHomeBtn.hide();
		lineHdPrevBtn.hide();
		pages.eq(4).find('.page-wrapper').animate({ opacity: 0 }, 700*animationMultiplier, 'swing',  function() {
			pages.eq(4).removeClass('active');
			pages.eq(4).find('.page-wrapper').css({ opacity: 1 });
		});
		callback();
	};

	var showHdiLine = function() {
		pages.eq(6).addClass('active');
		lineHdiHomeBtn.show();
		lineHdiPrevBtn.show();
		lineHdiHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineHdiPacks.css({ 'opacity': '0', 'left': '200px' });
		lineHdiPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
	};

	var hideHdiLine = function(callback) {
		lineHdiHomeBtn.hide();
		lineHdiPrevBtn.hide();
		pages.eq(6).find('.page-wrapper').animate({ opacity: 0 }, 700*animationMultiplier, 'swing',  function() {
			pages.eq(6).removeClass('active');
			pages.eq(6).find('.page-wrapper').css({ opacity: 1 });
		});
		callback();
	};

	var showHdsLine = function() {
		pages.eq(7).addClass('active');
		lineHdsHomeBtn.show();
		lineHdsPrevBtn.show();
		lineHdsHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineHdsPacks.css({ 'opacity': '0', 'left': '200px' });
		lineHdsPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
	};

	var hideHdsLine = function(callback) {
		lineHdsHomeBtn.hide();
		lineHdsPrevBtn.hide();
		pages.eq(7).find('.page-wrapper').animate({ opacity: 0 }, 700*animationMultiplier, 'swing',  function() {
			pages.eq(7).removeClass('active');
			pages.eq(7).find('.page-wrapper').css({ opacity: 1 });
		});
		callback();
	};

	var showiSwitchLine = function() {
		pages.eq(5).addClass('active');
		lineiSwitchHomeBtn.show();
		lineiSwitchPrevBtn.show();
		lineiSwitchHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineiSwitchPacks.css({ 'opacity': '0', 'left': '200px' });
		lineiSwitchPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
	};

	var hideiSwitchLine = function(callback) {
		lineiSwitchHomeBtn.hide();
		lineiSwitchPrevBtn.hide();
		pages.eq(5).find('.page-wrapper').animate({ opacity: 0 }, 700*animationMultiplier, 'swing',  function() {
			pages.eq(5).removeClass('active');
			pages.eq(5).find('.page-wrapper').css({ opacity: 1 });
		});
		callback();
	}; 

	var showSeriesLine = function() {
		pages.eq(8).addClass('active');
		lineSeriesHeader1.hide().delay(200*animationMultiplier).fadeIn(700*animationMultiplier);
		lineSeriesPrevBtn.hide().css({ 'left': '1174px' }).show().animate({ 'left': '36px' }, 1200*animationMultiplier, 'easeOutCubic');
		lineSeriesPacks.css({ 'opacity': '0', 'left': '200px' });
		lineSeriesPacks.animate({ 'opacity': '1', 'left': '0px' }, 700*animationMultiplier);
		lineSeriesPackBtns.css({ 'top': '+=300px' });
		lineSeriesPackBtns.eq(0).delay(700*animationMultiplier).animate({ 'top': '-=300px' }, 700*animationMultiplier, 'easeOutCubic');
		lineSeriesPackBtns.eq(1).delay(800*animationMultiplier).animate({ 'top': '-=300px' }, 700*animationMultiplier, 'easeOutCubic');
		lineSeriesPackBtns.eq(2).delay(900*animationMultiplier).animate({ 'top': '-=300px' }, 700*animationMultiplier, 'easeOutCubic');
		lineSeriesPackBtns.eq(3).delay(1000*animationMultiplier).animate({ 'top': '-=300px' }, 700*animationMultiplier, 'easeOutCubic');
		lineSeriesPackBtns.eq(4).delay(1100*animationMultiplier).animate({ 'top': '-=300px' }, 700*animationMultiplier, 'easeOutCubic');
	};

	var hideSeriesLine = function(callback) {
		lineSeriesPrevBtn.fadeOut(600*animationMultiplier);
		pages.eq(8).find('.page-wrapper').animate({ opacity: 0 }, 600*animationMultiplier, 'swing',  function() {
			pages.eq(8).removeClass('active');
			pages.eq(8).find('.page-wrapper').css({ opacity: 1 });
			callback();
		});
	};

	$('.btn, .home-btn, .next-btn, .prev-btn, #home .sidelink a, #nanotek-info .info-pack a, #hd-info .info-pack a').on('touchstart', function(e) {
		$(this).addClass('active');
	}).on('mousedown', function(e) {
		$(this).addClass('active');
	}).on('touchend', function(e) {
		$(this).delay(500).removeClass('active');
	}).on('mouseup', function(e) {
		$(this).delay(500).removeClass('active');
	}).on('touchcancel', function(e) {
		$(this).delay(500).removeClass('active');
	}).on('touchleave', function(e) {
		$(this).delay(500).removeClass('active');
	});

	var hdRotatePackModel = new ThreeSixty({
		container: '#model-hd',
		images: '#model-hd .model-images',
		spinner: '#model-hd .model-spinner',
		imagePath: '/nanotek/assets/hd/rotation/HD_2.5_blue_.RGB_color.',
		frames: 36,
		startFrame: 0,
		speed: 1.2,
		limited: false,
		direction: 'horizontal',
		spinnerId: 'model-hd-spinner'
	})

	var nanotekRotatePackModel = new ThreeSixty({
		container: '#model-nanotek',
		images: '#model-nanotek .model-images',
		spinner: '#model-nanotek .model-spinner',
		imagePath: '/nanotek/assets/nanotek/rotation/nanotek_.RGB_color.',
		frames: 36,
		startFrame: 0,
		speed: 1.2,
		limited: false,
		direction: 'horizontal',
		spinnerId: 'model-nanotek-spinner'
	})

	showSeriesLine();

})();




