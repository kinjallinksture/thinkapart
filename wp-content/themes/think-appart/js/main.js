(function(){
	var scrollMagicController = null;
	var lastScrollTop = 0;

	$(document).ready(function($){
		fixVH();
		function adjustMegaMenuHeight() {
			$('.service-nav-item').each(function () {
				if ($('.service-nav-item').is(':hover')) {
					var contentHeight = $(this).find('.mega-menu-inner').outerHeight(true);
					$('.mega_menu_content').css('height', contentHeight);
				}
			});
		}
		$('.service-nav-item').hover(
			function() {
				// On hover, set the height based on the content size
				var contentHeight = $(this).find('.mega-menu-inner').outerHeight(true); 
				$('.mega_menu_content').css('height', contentHeight);
				$('body').addClass('show-mega-menu');
			},
			function() {
				// On hover out, reset the height (if necessary)
				$('.mega_menu_content').css('height', '0');
				$('body').removeClass('show-mega-menu');
			}
		);
		$('.mega_menu_content').css('height', '0');

		$(window).on('resize', function () {
			adjustMegaMenuHeight();
		});
		
		$('form.wpcf7-form input[type="checkbox"]').on('change', function() {
			var label = $(this).closest('label');
			// Check if the checkbox is checked
			if ($(this).prop('checked')) {
				// Add the 'checked' class if the checkbox is checked
				label.addClass('checked');
			} else {
				// Remove the 'checked' class if the checkbox is unchecked
				label.removeClass('checked');
			}
		});

		$('.budget-text, .budget').on('input', function () {
			const budgetTextValue = parseFloat($('.budget-text').val());
			const estimateValue = parseFloat($('.budget').val());
			if (budgetTextValue === 0 || estimateValue === 0 && (!isNaN(budgetTextValue) || !isNaN(estimateValue)) ) {
				$(this).next('.wpcf7-not-valid-tip').remove();
				$(this).after('<span role="alert" class="wpcf7-not-valid-tip">Value cannot be zero.</span>');
			} else if (budgetTextValue < estimateValue) {
				// If budget-text is less than budget-estimate, show error message
				if ($(this).next('.wpcf7-not-valid-tip').length === 0) {
					$(this).after('<span class="wpcf7-not-valid-tip">Value cannot be more than budget estimate.</span>');
				}
			} else {
				$(this).next('.wpcf7-not-valid-tip').remove(); // Remove error if valid
			}
		});
		
	})

	$(window).on('load', function(){
		initVariables();

		bindEvents();

		subServiceMenu();

		returnServiceMenu();

		header();

		videoContainer();

		parallax();

		typedText();

		moduleDisplay();

		moduleServices();

		moduleOffices();

		moduleAboutHome();

		readMore();

		moduleSliderScroll();

		moduleProcess();

		moduleProcessMisson();

		moduleReview();

		projectSinglePage();

		moduleFilterWorks();

		moduleBannerTextButtonFixed();

		moduleSliderImages();

		moduleOfficesJobs();

		moduleSylo();

		moduleSwiperinit();
	})

	function moduleSwiperinit() {
		/****** Swiper slider using params ******/
		let swiperObjs = [];
		$('[data-slider-options]').each(function () {
			var _this = $(this),
				sliderOptions = _this.attr('data-slider-options');

			if (typeof (sliderOptions) !== 'undefined' && sliderOptions !== null) {
				sliderOptions = $.parseJSON(sliderOptions);

				var swiperObj = new Swiper(_this[0], sliderOptions);
				swiperObjs.push(swiperObj);
			}
		});
	}

	function initVariables(){
		scrollMagicController = new ScrollMagic.Controller();

	}

	function bindEvents() {
	    $('.header-container .menu-mobile-button').on('click', function(event) {
			$('body').toggleClass('show-menu');
	        $('.header-container .menu-mobile-button').toggleClass('opened');
	        $('.nav-container').toggleClass('opened');
	        $('html').toggleClass('overflow-hidden');
	        if ($('.sub_mega_menu_content').hasClass('opened')) {
		        $('.sub_mega_menu_content').removeClass('opened');
				$('body').removeClass('show-menu mobile-services');
				$(this).removeClass('dark');
		    }
	    });
	}

	function subServiceMenu() {
	    $('.header-container .open-sub-menu').on('click', function(event) {
	        $('.header-container .menu-mobile-button').addClass('dark');
	        $('.sub_mega_menu_content').addClass('opened');
			$('body').addClass('mobile-services');
	    });
	}

	function returnServiceMenu() {
	    $('.header-container .return-main-nav').on('click', function(event) {
	        $('.header-container .menu-mobile-button').removeClass('dark');
	        $('.sub_mega_menu_content').removeClass('opened');
			$('body').removeClass('mobile-services');
	    });
	}

	 function fixVH(){
		var windowLastWidth = 0;
		var windowLastHeight = 0;

		$(window).on('resize', fix);
		fix();

		function fix(){
			$('.header-container').css('transition', 'none');
			$(document.body).css('--menu-height', $('.header-container').innerHeight() + 'px');
			$('.header-container').css('transition', '');

			var width = $(window).innerWidth();
			var height = $(window).innerHeight();
			if(width != windowLastWidth || Math.abs(height-windowLastHeight) > 150){
				document.body.style.setProperty('--vh', height/100 + "px");
				windowLastWidth = width;
				windowLastHeight = height;
			}
		}
	 }
	function header(){
		$('.header-container .menu-container .phone-number .text').each(function(i, item){
			var $item = $(item);
			$item.css('width', 'auto');
			$item.css('--width', $item.innerWidth() + 'px');
			$item.css('width', '');
		})

		$(window).scroll(function(event){
			if ($(window).scrollTop() > 100) {
				$('.header-container').addClass('sticky');
			} else {
				$('.header-container').removeClass('sticky');
			}
		})
	}

	function videoContainer(){
		var $currentVideoContainer = null;
		var $currentIconPause = null;
		$('.video-container .video').each(function(i, video){
			var $video = $(video);
			var $videoContainer = $video.closest('.video-container');
			var $iconPause = $videoContainer.find('.icon-pause');
			var $iconVolume = $videoContainer.find('.icon-volume');

			$videoContainer.css('--height', $videoContainer.innerHeight()+'px');
			$video.on('play', function(event){
				$videoContainer.addClass('playing');
				if($(window).innerWidth() > 800 && $videoContainer.closest('.module-cover-home').length > 0 && !$video.attr('autoplay')){
					animateScrollY($(window).scrollTop()+$videoContainer[0].getBoundingClientRect().top);
				}
			})
			$video.on('pause ended', function(event){
				$videoContainer.removeClass('playing');
			})
			$videoContainer.find('.icon-play').on('click', function(){
				video.play();
				$currentVideoContainer = $videoContainer;
				$currentIconPause = $iconPause;
				$(window).on('mousemove', moveIconPause);
			})
			$iconVolume.on('click', function(){
				if($iconVolume.hasClass('disabled')){
					video.muted = false;
					$iconVolume.removeClass('disabled')
				}else{
					video.muted = true;
					$iconVolume.addClass('disabled')
				}
			})
			if($(window).innerWidth() > 800){
				$iconVolume.hover(function(){
					$iconPause.addClass('hide');
				}, function(){
					$iconPause.removeClass('hide');
				})
			}
			$iconPause.on('click', function(){
				video.pause();
				$(window).off('mousemove', moveIconPause);
			})
		})

		function moveIconPause(event){
			var bounding = $currentVideoContainer[0].getBoundingClientRect();
			var x = event.clientX - bounding.x;
			var y = event.clientY - bounding.y;
			gsap.to($currentIconPause, .2, {top: y + 'px', left: x + 'px', ease: Power0.easeNone})
		}
	}

	function parallax(){
		$('.js-parallax').each(function(i, item){
			var $item = $(item);
			var move = 100;
			var tween = new TimelineMax();

			if($item.data('parallax-factor')){
				move *= parseFloat($item.data('parallax-factor'));
			}

			if($item.data('parallax-circle')){
				tween.fromTo(item, 1, {y: (move*-1)+"px"},{y: move+"px", ease: Linear.easeNone})
			}else{
				tween.fromTo(item, 1, {y: move+"px"},{y: "0px", ease: Linear.easeNone})
			}

			var scene = new ScrollMagic.Scene({
				triggerElement: item,
				triggerHook: 1.5,
				duration: $(window).innerHeight()
			})
			.setTween(tween)
			.addTo(scrollMagicController)
		})
	}

	function typedText(){
		$(".typed-container").each(function(index, typedContainer) {
			var typed = new Typed($(typedContainer).find('.typed')[0], {
				stringsElement: $(typedContainer).find('.typed-text-hidden')[0],
				typeSpeed: 100,
				backSpeed: 0,
				backDelay: 800,
				startDelay: 100,
				loop: true,
				cursorChar: '_',
			});
		});
	}

	function moduleDisplay(){
		var $displayContainers = $('.display-container');
		$displayContainers.each(function(i,item){
			var $displayContainer = $(item);
			var $textContainer = $displayContainer.find('.display-text-container');
			var $textWrapper = $textContainer.find('.display-text-wrapper');
			var factor = .28;
			if($displayContainer.hasClass('slow')){
				factor = .44;
			}

			if($(window).innerWidth() <= 800){
				factor *= .3;
			}

			duplicateContent($textContainer, $textWrapper, factor);

			$(window).on('resize', function(){
				$textContainer.html($textWrapper.clone());
				$textWrapper = $textContainer.find('.display-text-wrapper');
				duplicateContent($textContainer, $textWrapper, factor);
			});
		});

		function duplicateContent($textContainer, $textWrapper, factor){
			var containerWidth = $textContainer.innerWidth();
			var wrapperWidth = $textWrapper.innerWidth();
			var count = Math.ceil(containerWidth/wrapperWidth);
			var move = (wrapperWidth/containerWidth)*100;
			var time = move*factor;

			for(var i = 0; i < count; i++){
				var $clone = $textWrapper.clone();
				$textContainer.append($clone);
			}

			gsap.fromTo($textContainer, {x: '0%'}, {x: '-'+move+'%', duration: time, ease: Power0.easeNone, repeat: -1})
		}
	}

	function moduleServices(){
		var $currentTarget, bounding, width, height;
		$('.module-services').each(function(i, module){
			var $module = $(module);
			var $button = $module.find('.button-container .button');
			$module.find('.service-container').hover(function(event){
				$currentTarget = $(event.currentTarget);
				bounding = $currentTarget[0].getBoundingClientRect();
				width = $currentTarget.innerWidth();
				height = $currentTarget.innerHeight();
				$module.css('--color-bg', $currentTarget.data('color-bg'));
				$module.css('--color-font', $currentTarget.data('color-font'));
				$module.css('--color-hover', $currentTarget.data('color-hover'));
				if($(window).innerWidth() > 800){
					$(window).on('mousemove', mouseMove);
				}
				if($button.length > 0 && $currentTarget.data('color-bg') == '#00D3A8'){
					$button.removeClass('button-green-hover-white');
					$button.addClass('button-full-white');
				}
			}, function(event){
				$module.css('--color-bg', '');
				$module.css('--color-font', '');
				$module.css('--color-hover', '');
				if($(window).innerWidth() > 800){
					$(window).off('mousemove', mouseMove);
				}
				if($button.length > 0){
					$button.addClass('button-green-hover-white');
					$button.removeClass('button-full-white');
				}
			})
		})
		function mouseMove(event){
			var percentX = (event.clientX - bounding.left - width*.5)/width;
			var percentY = (event.clientY - bounding.top - height*.5)/height;
			var x = width*.2*percentX;
			var y = 40*percentY;
			var rotateZ = 10*percentX;
			gsap.to($currentTarget.find('.image-container'), 5, {x, y, rotateZ})
		}
	}

	function moduleOffices(){
		$('.module-offices').each(function(i, module){
			var $module = $(module);
			var $steps = $module.find('.steps-container .step');
			var swiper = new Swiper($module.find('.slider-container')[0], {
				effect: "cards",
				// cardsEffect: {
				// 	perSlideOffset: 100,
				// 	perSlideRotate: 45,
				// 	// rotate: false,
				// },
				slideToClickedSlide: true,
				on : {
					init : function(){
						var maxHeight = $module.find('.slide').innerWidth()*1.23;
						$module.find('.slide').each(function(i, item){
							maxHeight = Math.max(maxHeight, $(item).innerHeight());
							var $time = $(item).find('.time');
							$time.text( new Date().toLocaleString("en-US", {timeZone: $time.data('timezone'), hour: "2-digit", minute: "2-digit", second: "2-digit"}) );
							setInterval(function(){
								$time.text( new Date().toLocaleString("en-US", {timeZone: $time.data('timezone'), hour: "2-digit", minute: "2-digit", second: "2-digit"}) );
							}, 1000)
						})
						$module.find('.slide').css('min-height', maxHeight + 'px');
					},
					activeIndexChange: function(){
						$steps.removeClass('active');
						$($steps[swiper.activeIndex]).addClass('active');
					},
				}
			});
			$steps.on('click', function(event){
				var index = $(event.currentTarget).data('id');
				swiper.slideTo(index);
			})
			$module.find('.button-copy').on('click', function(event){
				copyTextToClipboard($(event.currentTarget).data('copy-text'));
			})
		})
	}

	function moduleAboutHome(){
		$('.module-about-home').each(function(i, module){
			var $module = $(module);
			
			var swiper = new Swiper(module, {
				slidesPerView: 1.7,
				spaceBetween: 12,
				enabled: true,
				breakpoints: {
					800: {
						slidesPerView: 3.7,
						spaceBetween: 24,
						enabled: false,
					}
				}
			});

			if($(window).innerWidth() > 800){
				var config = {percent : 0};
				var tween = new TimelineMax().fromTo(config, 1, {percent: 0},{percent: 1, ease: Power0.easeNone, onUpdate:function(event){
					swiper.setProgress(config.percent, 400);
				}})

				var $imagesContainer = $module.find('.images-container');
				var trigger = (1-($imagesContainer.innerHeight()/$(window).innerHeight()));
				var scene = new ScrollMagic.Scene({
					triggerElement: $imagesContainer[0],
					triggerHook: trigger,
					duration: $(window).innerHeight()*trigger
				})
				.setTween(tween)
				.addTo(scrollMagicController)
			}

			var $moreInfoContainer = $module.find('.more-info-container');
			var $moreInfoText = $moreInfoContainer.find('.more-info-title .text');
			var moreInfoText = {
				opened: $moreInfoText.data('text-opened'),
				closed: $moreInfoText.data('text-closed'),
			}
			$moreInfoContainer.find('.more-info-title').on('click', function(event){
				var height = 0;
				var text = moreInfoText.closed; 
				if(!$moreInfoContainer.hasClass('opened')){
					height = $moreInfoContainer.find('.more-info-content-wrapper').innerHeight();
					text = moreInfoText.opened; 
				}
				gsap.to($moreInfoContainer.find('.more-info-content'), .6, {height: height + 'px', clearProps: 'height', onStart: function(){
					$moreInfoContainer.toggleClass('opened');
					$moreInfoText.text(text);
				}})
			})
		})
	}

	function readMore(){
		$('.module-question').each(function(i, module){
			var $module = $(module);

			var $moreInfoContainer = $module.find('.more-info-container');
			var $moreInfoText = $moreInfoContainer.find('.more-info-title .text');
			var moreInfoText = {
				opened: $moreInfoText.data('text-opened'),
				closed: $moreInfoText.data('text-closed'),
			}
			$moreInfoContainer.find('.more-info-title').on('click', function(event){
				var height = 0;
				var text = moreInfoText.closed; 
				if(!$moreInfoContainer.hasClass('opened')){
					height = $moreInfoContainer.find('.more-info-content-wrapper').innerHeight();
					text = moreInfoText.opened; 
				}
				gsap.to($moreInfoContainer.find('.more-info-content'), .6, {height: height + 'px', clearProps: 'height', onStart: function(){
					$moreInfoContainer.toggleClass('opened');
					$moreInfoText.text(text);
				}})
			})
		})
	}

	function moduleSliderScroll(){
		$('.module-slider-scroll').each(function(i, module){
			var $module = $(module);
			var $screensContainer = $module.find('.screens-container');
			if($screensContainer.find('.screen').length > 1){
				var $steps = $module.find('.steps-container .step');
		
				if($(window).innerWidth() <= 800 || $module.hasClass('no-stuck')){
					// Initialize Swiper with correct options for version 9.x
					var swiper = new Swiper($module.find('.screens-wrapper')[0], {
						slidesPerView: 1,
						wrapperClass: 'screens-container',
						slideClass: 'screen',
						autoHeight: true,
						breakpoints: {
							800: {
								autoHeight: false,
							},
						},
						pagination: {
							el: '.steps-container',
							clickable: true,
							renderCustom: function(swiper, current, total){
								$steps.removeClass('active');
								$steps.eq(current - 1).addClass('active');
							}
						},
					});
				} else {
					var width = $screensContainer.innerWidth() - $(window).innerWidth();
		
					// Adjusted ScrollMagic & TimelineMax code
					var tween = new TimelineMax().fromTo($screensContainer, 1, {x: "0px"},{x: -width + "px", ease: Linear.easeNone, onUpdate: function(){
						var index = Math.round(this.progress() * ($steps.length - 1));
						$steps.removeClass('active');
						$steps.eq(index).addClass('active');
					}});
		
					var scene = new ScrollMagic.Scene({
						triggerElement: module,
						triggerHook: 0,
						duration: width
					})
					.setPin(module)
					.setTween(tween)
					.addTo(scrollMagicController);
				}
			}
		});
		
	}

	function moduleProcess(){
		$('.module-process .process-container').each(function(i, module){
			var $module = $(module);
			var $textContainer = $module.find('.text-container');
			var changeActive = false;

			var tween = new TimelineMax();

			$textContainer.each(function(i, item){
				tween.fromTo($(item).find('.line'), 1, {height: '0px'}, {height: '100px', ease: Linear.easeNone, onComplete: function(){
						changeIndex($textContainer, Math.min(i+1, $textContainer.length-1));
				}, onReverseComplete: function(){
						changeIndex($textContainer, Math.max(i-1, 0));
				}})
			})

			tween.fromTo($module.find('.image-container1'), $textContainer.length, {rotate: 0},{rotate: 320, ease: Linear.easeNone}, '-='+$textContainer.length)

			var scene = new ScrollMagic.Scene({
				triggerElement: module,
				triggerHook: .5,
				duration: $module.innerHeight()
			})
			.setTween(tween)
			.addTo(scrollMagicController)
		})

		function changeIndex($textContainer, index){
			$textContainer.removeClass('active');
			$textContainer[index].classList.add('active');
		}
	}

	function moduleProcessMisson(){
		$('.module-process .process-container-misson').each(function(i, module){
			var $module = $(module);
			var $textContainer = $module.find('.text-container');
			var changeActive = false;

			var tween = new TimelineMax();

			$textContainer.each(function(i, item){
				tween.fromTo($(item).find('.line'), 1, {height: '0px'}, {height: '0px', ease: Linear.easeNone, onComplete: function(){
						changeIndex($textContainer, Math.min(i+1, $textContainer.length-1));
				}, onReverseComplete: function(){
						changeIndex($textContainer, Math.max(i-1, 0));
				}})
			})

			var scene = new ScrollMagic.Scene({
				triggerElement: module,
				triggerHook: .7,
				duration: $module.innerHeight()
			})
			.setTween(tween)
			.addTo(scrollMagicController)
		})

		function changeIndex($textContainer, index){
			console.log( index );
			$textContainer.removeClass('active');
			$textContainer[index].classList.add('active');
		}
	}

	function moduleReview(){
		$('.module-review').each(function(i, module){
			var $module = $(module);
			
			var swiper = new Swiper(module, {
				slidesPerView: 1,
				enabled: true,
				pagination: {
					el: $module.find('.steps-container')[0],
					clickable: true,
				},
			});
		});
	}

	function projectSinglePage(){
		var $contentProject = $('.content-project');
		var $changeBackground = $('.change-background');
		if($contentProject.length > 0 && $changeBackground.length > 0){
			$(window).scroll(checkCurrentBackgroundColor);
			checkCurrentBackgroundColor();
		}

		function checkCurrentBackgroundColor(){
			var currentSection = $('.change-background.first-module');
			var limit = $(window).innerHeight()*.5;
			var windowScrollTop = $(window).scrollTop();
			$changeBackground.each(function(i,item){
				if($(item).offset().top - windowScrollTop - limit <= 0){
					currentSection = item;
				}
			})
			if(currentSection){
				var $currentSection = $(currentSection);
				var projectClass = $currentSection.data('class');
				var projectAttrClass = $currentSection.data('style');
				clearBackgroundColor();
				$contentProject.addClass(projectClass);
				$contentProject.attr('style',projectAttrClass);
			}else{
				clearBackgroundColor();
			}
		}

		function clearBackgroundColor(){
			$contentProject.removeClass(function (index, className) {
				return (className.match (/(^|\s)background-\S+/g) || []).join(' ');
			});
			$contentProject.removeClass(function (index, className) {
				return (className.match (/(^|\s)font-color-\S+/g) || []).join(' ');
			});
		}
	}

	function moduleFilterWorks(){
		var $moduleFilterWorks = $('.module-filter-works');
		if($moduleFilterWorks.length > 0){
			var $allFilters = $moduleFilterWorks.find('.filter-work');
			var $allWorks = $('.module-works .work-container');
			var $bannerWorkContainer = $('.module-works .work-container.banner-text-button');
			var $bannerModule = $('.module-banner-text-button');
			var filtering = false;
			$moduleFilterWorks.find('.filter-work').on('click', function(event){
				if(!filtering){
					filtering = true;
					var $currentTarget = $(event.currentTarget);
					$allFilters.removeClass('active');
					gsap.to($allWorks, .4, {opacity: 0, ease: Power2.easeIn, onComplete: function(){
						$allWorks.addClass('hidden');
						$currentTarget.addClass('active');
						var $filteredWorks = $('.module-works .work-container[data-filter*="'+$currentTarget.data('filter')+'"]');
						$filteredWorks.removeClass('hidden');
						if($filteredWorks.length % 2 == 0){
							// $bannerWorkContainer.removeClass('hidden');
							$bannerModule.addClass('hidden');
						}else{
							$bannerWorkContainer.addClass('hidden');
							$bannerModule.removeClass('hidden');
						}
						gsap.to($allWorks, .4, {opacity: 1, ease: Power2.easeIn, onComplete: function(){
							filtering = false;
						}})
					}})
				}
			});
		}
	}

	function moduleBannerTextButtonFixed(){
		var $moduleFixed = $('.module-banner-text-button.fixed');
		var $moduleFixedHide = $('.module-banner-text-button.fixed-hide');
		if($moduleFixed.length > 0 && $moduleFixedHide.length > 0){
			$(window).scroll(function(){
				if($moduleFixedHide[0].getBoundingClientRect().top < $(window).innerHeight()){
					$moduleFixed.addClass('hide');
				}else{
					$moduleFixed.removeClass('hide');
				}
			})
		}
	}
	
	function moduleSliderImages() {
		
			const slider = new Swiper(".module-slider-images .slider-container", {
				effect: 'fade',
				fadeEffect: {
					crossFade: true, // Enables the fade transition effect between slides
				},
				speed: 1000,
				watchSlidesProgress: true,
				loop: true,
				autoplay: {
					delay: 6000,
					disableOnInteraction: false
				},
				slidesPerView: 1,
				navigation: {
					nextEl: ".story__next",
					prevEl: ".story__prev",
				},
				pagination: {
					el: '.story__pagination',
					renderBullet: function (index, className) {
						return '<div class="' + className + '"> <div class="swiper-pagination-progress"></div> </div>';
					}
				},
				on: {
					autoplayTimeLeft(swiper, time, progress) {
						let currentSlide = document.querySelectorAll('.module-slider-images .swiper-slide')[swiper.activeIndex];
						let currentBullet = document.querySelectorAll('.module-slider-images .swiper-pagination-progress')[swiper.realIndex];
						let fullTime = currentSlide.dataset.swiperAutoplay ? parseInt(currentSlide.dataset.swiperAutoplay) : swiper.params.autoplay.delay;
			
						let percentage = Math.min( Math.max ( parseFloat(((fullTime - time) * 100 / fullTime).toFixed(1)), 0), 100) + '%';
			
						gsap.set(currentBullet, {width: percentage});
					},
					transitionEnd(swiper) {

						let allBullets = $('.module-slider-images .swiper-pagination-progress');
						let bulletsBefore = allBullets.slice(0, swiper.realIndex);
						let bulletsAfter = allBullets.slice(swiper.realIndex, allBullets.length);
						if(bulletsBefore.length) {gsap.set(bulletsBefore, {width: '100%'})}
						if(bulletsAfter.length) {gsap.set(bulletsAfter, {width: '0%'})}
					},
				}
			});
	}
	
	function moduleOfficesJobs(){
		var $module = $('.module-offices-jobs');
		if($module.length > 0){
			$module.find('.buttons-container .button').on('click', function(event){
				var $currentTarget = $(event.currentTarget);
				var office = $currentTarget.data('office');
				$module.find('.buttons-container .button').removeClass('active');
				$currentTarget.addClass('active');
				$module.find('.offices-container .office-container').removeClass('active');
				$module.find('.offices-container .office-container[data-office="'+office+'"]').addClass('active');
			});
		}
	}

	function moduleSylo(){
		var $module = $('.module-sylo');
		if($module.length > 0){
			$module.find('.section-container .links-container-wrapper').each(function(i,item){
				$(item).css('--height', $(item).find('.links-container').innerHeight()+'px');
			})
			$module.find('.section-container .section-title-container').on('click', function(event){
				$(event.currentTarget).closest('.section-container').toggleClass('opened');
			});
		}
	}

	function animateScrollY(to){
		var config = {
			y: $(window).scrollTop(),
		}
		gsap.to(config, {y : to, duration: .6, ease:Power0.easeNone, onUpdate:function(){
			window.scrollTo(0, config.y);
		}})
	}

	function fallbackCopyTextToClipboard(text) {
		var textArea = document.createElement("textarea");
		textArea.value = text;

		// Avoid scrolling to bottom
		textArea.style.top = "0";
		textArea.style.left = "0";
		textArea.style.position = "fixed";

		document.body.appendChild(textArea);
		textArea.focus();
		textArea.select();

		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
		} catch (err) {
			console.error('Fallback: Oops, unable to copy', err);
		}

		document.body.removeChild(textArea);
	}
	function copyTextToClipboard(text) {
		if (!navigator.clipboard) {
			fallbackCopyTextToClipboard(text);
			return;
		}
		navigator.clipboard.writeText(text).then(function() {}, function(err) {
			console.error('Async: Could not copy text: ', err);
		});
	}

	// Filter Button Blog Page
	$(document).ready(function() {
        function initializeOffCanvas() {
            $("#openPopupButton").click(function() {
                // Toggle the off-canvas container
                $("#offCanvas").toggleClass("open");
                $(".overlay").toggleClass("active");
            });

            $("#closeOffCanvasButton").click(function() {
                // Close the off-canvas container
                $("#offCanvas").removeClass("open");
                $(".overlay").removeClass("active");
            });
        }

        // Close off-canvas when clicking outside of it
        $(document).on("click", function(event) {
            if (!$(event.target).closest("#offCanvas").length && !$(event.target).is("#openPopupButton")) {
                // Close the off-canvas container
                $("#offCanvas").removeClass("open");
                $(".overlay").removeClass("active");
            }
        });

        initializeOffCanvas();
    });

})();
