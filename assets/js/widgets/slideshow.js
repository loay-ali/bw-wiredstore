(function($){
	
	$('.slideshow').each((ind,ele) => {
			
		let curr_slide = 0;
		const max_slide = $(ele).attr('num-of-slides') - 1;
	
		$(ele).find("#progress-bar")
		.stop()
		.css({'width':'0%'})
		.animate({'width':'100%'},7500,'linear',function(){
			
			change_slide(curr_slide + 1,ele);
		});
	
		const $mainSlide = $(ele).find('#main-slide');
		const slide_effect = $mainSlide.attr('effect');
		
		if(['zoom','fade','flip'].indexOf(slide_effect) != -1) {
			
			$mainSlide.css({'position':'relative'});
			
			$mainSlide.find('div').css({
				
				'position':'absolute',
				'top':'0',
				"left":"0",
				"z-index":'0',
				'opacity':'0'
			});
			
			$mainSlide.find("#slide-0").css({
				
				'opacity':'1',
				'backface-visibility':'hidden',
				'z-index': '1'
			});
		}
		
		if(slide_effect == "flip") {
			
			$mainSlide.css({'transform-style':'preserve-3d'});
			$mainSlide.find("div").css({'transform':'rotateY(180deg)'});
			$mainSlide.find("#slide-0").css({'transform':'rotateY(0deg)'});
		}
		
		//Pause/Resume The Slideshow
		let slideCurrWidth = 0;
		let stopping = false;
		$(ele).find("#pause-slide").click(function(){
			
			if($(this).find("i").attr("class") == "bwi bwi-pause") {//Pause The Slide
				
				$(this).siblings("#progress-bar").stop();
				slideCurrWidth = $(this).siblings("#progress-bar").css("width");
				
				stopping = true;
				
				$(this).find("i").attr("class",'bwi bwi-play');
			}else {//Resume The Slide
				
				let timeToReach = (slideCurrWidth.toString().split("px")[0] / window.outerWidth)*100;
				timeToReach = (100 - timeToReach) * 75;
				
				stopping = false;
				
				$(this).siblings("#progress-bar")
				.css('width',slideCurrWidth.toString().split("px")[0])
				.animate({'width':'100%'},timeToReach,'linear',function(){
					
					change_slide(curr_slide + 1,ele);
				});
				
				$(this).find("i").attr("class",'bwi bwi-pause');			
			}
		});
		
		function change_slide (to,slideElement) {
			
			if(stopping == false) {
			
				$(slideElement).find("#progress-bar")
				.stop()
				.css({'width':'0%'})
				.animate({'width':'100%'},7500,'linear',function(){
					
					change_slide(curr_slide + 1,slideElement);
				});
			}
			
			//Main The Slide Limits.
			if( to > max_slide ) { to = 0; }
			if( to < 0 ) { to = max_slide; }
			
			let last_slide = curr_slide;
			
			$(slideElement).find("#num-of-slides button:nth-of-type(" + (curr_slide + 1) + ")").attr('id',"");
			
			curr_slide = to;
			
			$(slideElement).find("#num-of-slides button:nth-of-type(" + (curr_slide + 1) + ")").attr('id',"active");
			
			//Check The Effect.
			switch(slide_effect) {
				
				case "none":
				default:
				
					$(slideElement).find("#main-slide").css({"display":"flex","left":"-"+ 100 * curr_slide +"%",'z-index':'1'});
				break;
				
				case "slide":
				
					$(slideElement).find("#main-slide").css({"display":"flex","left":"-"+ 100 * curr_slide +"%","transition":"all 0.5s ease",'z-index':'1'});
				break;
				
				case "fade":
				
					$(slideElement).find("#main-slide #slide-" + last_slide).animate({'opacity':'0'}).css('z-index','0');
					
					$(slideElement).find("#main-slide #slide-" + curr_slide).animate({'opacity':'1.0'}).css('z-index','1');
				break;
				
				case "zoom":
				
					$(slideElement).find("#main-slide #slide-" + last_slide).css({'transition':'','transform':'scale(1)','z-index': '0'});
				
					$(slideElement).find("#main-slide #slide-" + last_slide).css({
						
						'transition':"all 1.0s ease",
						'z-index':'0',
						'transform':'scale(1.5)',
						'opacity':'0'
					});
					
					$(slideElement).find("#main-slide #slide-" + curr_slide).animate({'opacity':'1'}).css('z-index','1');
					$(slideElement).find("#main-slide #slide-" + curr_slide).css({'transition':'','transform':'scale(1)'});
				break;
				
				case "flip":
				
					$(slideElement).find("#main-slide #slide-" + last_slide).css({
						
						'transform':'rotateY(180deg)',
						'transition':'all 1.0s ease',
						'backface-visibility':'hidden'
					});
					
					$(slideElement).find("#main-slide #slide-" + curr_slide).css({
						
						
						'transform':'rotateY(0deg)',
						'transition':'all 1.0s ease',
						'opacity':'1',
						'backface-visibility':'hidden',
						'z-index': '1'
					});
				break;
			}
		}
		
		$(ele).find("#slide-move-left").click(function(){ change_slide(curr_slide - 1,ele); });
		
		$(ele).find("#slide-move-right").click(function(){ change_slide(curr_slide + 1,ele); });
		
		$(ele).find("#num-of-slides button").click(function() {
			
			change_slide(Number(this.innerHTML) - 1,ele);
		});

		//Sliding ( Using Mouse )
		let last_mouse_pos = 0;
		
		if($mainSlide != null) {
				
			$mainSlide.bind("mousedown",function(e){
				
				last_mouse_pos = e.clientX;
			});
			
			if(slide_effect == "slide") {
				
				$mainSlide.bind("mousemove",function(e) {
					
					if(e.buttons > 0) {
						
						if((e.clientX - last_mouse_pos) < 100 && (e.clientX - last_mouse_pos) > -100) {
							
							$mainSlide.css('left',"calc("+ (e.clientX - last_mouse_pos) +"px + "+ (-curr_slide * 100) +"%)");
						}
					}
				});
			}
		
			$mainSlide.bind("mouseup",function(e){
			
				if((last_mouse_pos - e.clientX) > 75) {
					
					change_slide(curr_slide + 1,ele);
			
				}else if((last_mouse_pos - e.clientX) < -5) {
					
					change_slide(curr_slide - 1,ele);
				}
				
				last_mouse_pos = 0;
			});
		}

		//Sliding ( Using Mouse )
		let last_touch_pos = 0;
			
		$mainSlide.bind("touchstart",function(e){
			
			last_touch_pos = e.changedTouches[0].clientX;
		});
		
		$mainSlide.bind("touchend",function(e){
			
			let the_distance = last_touch_pos - e.changedTouches[0].clientX;
			
			if(the_distance > 75) {
				
				change_slide(curr_slide + 1,ele);
		
			}else if(the_distance < -5) {
				
				change_slide(curr_slide - 1,ele);
			}
			
			last_touch_pos = 0;
		});
	});
})(jQuery);