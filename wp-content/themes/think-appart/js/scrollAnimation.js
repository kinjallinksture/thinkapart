(function($){
	new ScrollAnimations();

	function ScrollAnimations(){
		var animableElements = null;
		var intersectionObserver = null;

		constructor();

		function constructor(){
			$(window).on('load', function(){
				initVariables();
				window.scrollTo(0,0);
				setTimeout(function(){
					window.scrollTo(0,0);
					prepareGeneralAnimations();
					bindEvents();
				}, 100)
			});
		};

		function initVariables(){
			animableElements = $(".js-animate");

			if(intersectionObserver === null){
				intersectionObserver = new IntersectionObserver(
					function(entries, observer){ 
						var myDelay = 0;
						entries.forEach( function(elem, index){
							if(  elem.isIntersecting ) {
								elem = elem.target;
								intersectionObserver.unobserve(elem);
								elem.classList.add("js-animated");
								myDelay = animateGeneralElement(elem, myDelay);
								myDelay += 0.2;
							}
						});
					}, 
					{rootMargin: "0px 0px -"+window.innerHeight*0.1+"px 0px"}
				);
			}else{
				firstTime = false;
			}
		}
		
		function bindEvents(){
			for (var i = 0; i < animableElements.length; i++) {
				intersectionObserver.observe(animableElements[i]);
			}
		}

		function prepareGeneralAnimations($container){
			var elements = animableElements;
			if($container != undefined){
				elements = $container.find(".js-animate");
			}
			for (var i = 0; i < elements.length; i++){
				var $elem = $(elements[i]);
				$elem.removeClass("js-animated");

				if($elem.data("animation-type") == "top-opacity"){
					gsap.set($elem, {opacity: 0, y: 100, 'pointer-events': 'none'});
				}else if($elem.data("animation-type") == "bottom-opacity"){
					gsap.set($elem, {opacity: 0, y: -100});
				}else if($elem.data("animation-type") == "right-opacity"){
					gsap.set($elem, {opacity: 0, x: -100});
				}else if($elem.data("animation-type") == "left-opacity"){
					gsap.set($elem, {opacity: 0, x: 100});
				}else if($elem.data("animation-type") == "right"){
					gsap.set($elem, {x: '-100%'});
				}else if($elem.data("animation-type") == "left"){
					gsap.set($elem, {x: '100%'});
				}else if($elem.data("animation-type") == "shapes"){
					$elem.find('.shape').each(function(i, item){
						$(item).data('bottom', $(item).css('bottom'));
						TweenLite.set(item, {bottom: '100%'});
					})
				}else{
					TweenLite.set($elem, {opacity: 0});
				}
			};
			$("body").addClass("js-animations-loaded");
		}

		function animateGeneralElement(element, myDelay){
			var myTime = 1.2;
			var $elem = $(element);
			var extraDelay = Number(element.getAttribute("data-animation-delay"));
			myDelay = Math.max(0, myDelay + extraDelay);

			if($elem.data("animation-type") == "top-opacity" || $elem.data("animation-type") == "bottom-opacity"){
				gsap.to($elem, myTime, {opacity: 1, y: 0, clearProps: 'pointer-events',  ease: Power2.easeOut, delay: myDelay});
			}else if($elem.data("animation-type") == "left-opacity" || $elem.data("animation-type") == "right-opacity"){
				gsap.to($elem, myTime, {opacity: 1, x: 0,  ease: Power2.easeOut, delay: myDelay});
			}else if($elem.data("animation-type") == "left" || $elem.data("animation-type") == "right"){
				gsap.to($elem, myTime, {x: 0,  ease: Power2.easeOut, delay: myDelay});
			}else if($elem.data("animation-type") == "shapes"){
				myDelay += .5;
				$elem.find('.shape').each(function(i, item){
					TweenLite.to(item, 1, {bottom: '0%', ease: Power2.easeIn, delay: myDelay + .1*(i+1)});
					TweenLite.to(item, 1, {bottom: $(item).data('bottom'), ease: Power2.easeOut, delay: myDelay + 1 + .1*(i+1), clearProps: 'bottom'});
				})
			}else{
				gsap.to($elem, myTime, {opacity: 1, ease: Power2.easeInOut, delay: myDelay});
			}
			return myDelay;
		}
	}
})(jQuery)