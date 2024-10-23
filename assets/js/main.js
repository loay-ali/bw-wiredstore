(function($){
	//Handle No Js Condition
	document.body.removeAttribute('noJs');
	
	//Appear On Scroll Elements.
	let appear_on_scroll_elements = document.querySelectorAll("[appear-from]");
	var appear_cursor = 0;

	//Nice Scroll Effect.
	$("a[href^='#']").click(function(e){
		e.preventDefault();
		let targetHash = e.currentTarget.hash;
		if(targetHash != "#" && targetHash.split("#").length > 2 && targetHash != '' && targetHash != null) {
			the_target = document.querySelector("#"+targetHash.split('#')[targetHash.split('#').length - 1]);
			console.log(the_target);
			$("html").animate( { 'scrollTop':the_target.offsetTop - 75 },1000 );
		}
	});

	//On Scroll Event.
	var timeoutId = null;
	window.addEventListener("scroll", function() {
			if ( timeoutId ) clearTimeout(timeoutId);
			timeoutId = setTimeout(scrollEvent, 200);
		}, true);

	function scrollEvent(e) {

		if( appear_on_scroll_elements.length > appear_cursor ) {

			//Check If We Reached Some ( Appear On Scroll ) Element.
			if( (appear_on_scroll_elements[appear_cursor].offsetTop + (appear_on_scroll_elements[appear_cursor].offsetHeight / 2)) < (window.scrollY + window.innerHeight) ) {

				//Check It's Effect.
				switch(appear_on_scroll_elements[appear_cursor].attributes['appear-effect'].value) {
					case "fade":
						appear_on_scroll_elements[appear_cursor].style.opacity = "1.0";
					break;

					case "slide":
						appear_on_scroll_elements[appear_cursor].style.top = "0";
						appear_on_scroll_elements[appear_cursor].style.left = "0";
						appear_on_scroll_elements[appear_cursor].style.opacity = "1.0";
					break;

					case "flip":
						appear_on_scroll_elements[appear_cursor].style.transform = "rotate(0deg)perspective(500px)";
						appear_on_scroll_elements[appear_cursor].style.opacity = "1.0";
					break;
				}
				//Delete The Offset
				appear_cursor++;
			}
		}

		if(window.scrollY > window.innerHeight) { $("#going-up").fadeIn();}
		else { $("#going-up").fadeOut();}
		
	}

	//Going Up Button
	$("#going-up").click(function(){
		$("html").animate({
		scrollTop:0});
	});

	//Toggle The Uppermenu.
	$("#open-menu,#close-menu").click(function(e){
		e.preventDefault();

		const $headerMenu = $("#header-menu");

		switch($headerMenu.attr('toggle-effect')) {
			
			case 'none':
			default:
				
				$headerMenu.toggle();
			break;
			
			case 'fade':
				
				$headerMenu.fadeToggle();
			break;
			
			case 'slide':
				
				if( this.id == 'open-menu' )
					$headerMenu.animate({'left': '0'});
				
				else
					$headerMenu.animate({'left': '100%'});
			break;
			
			case 'flip':
				
				if( this.id == 'open-menu' )
					$headerMenu.css({'transform': 'rotateY(0deg)'});
				
				else
					$headerMenu.css({'transform': 'rotateY(180deg)'});
			break;
		}

		$headerMenu.attr('aria-hidden',(this.id == 'open-menu') ? 'false':'true');

		if(this.id == "open-menu")
			document.querySelector("html").style.overflowY = 'hidden';
		
		else
			document.querySelector("html").style.overflowY = '';

		$(this).attr('aria-hidden','false')	;

	});
		
	//Upper Menu ( More ).
	let usingMore = false;
	
	const menus = document.querySelectorAll("#header-menu .menu");
	let menusItems = {
		
		'items': [],
		'count': []
	};
	
	for(let i = 0;i < menus.length;i++) {
		
		menusItems.items.push(menus[i].innerHTML);
		menusItems.count.push(menus[i].children.length);
	}
	
	function menu_more_list() {

		if( window.innerWidth > 750 ) {

			for(let i = 0;i < menus.length;i++) {
				
				let menu = menus[i];

				if((menu.clientWidth / menusItems.count[i]) < 100 && usingMore == false) {

					usingMore = true;

					//Cut Down 25% Of The Elements Into (More...) Menu.
					let menu_childs = menu.children;
					let cutten_elements = Array.from(menu_childs).slice(Math.floor(menu_childs.length * 0.5));
					let remain_elements = Array.from(menu_childs).slice(0,menu_childs.length - cutten_elements.length);
					
					menus[i].innerHTML = "";
					for(let ii = 0;ii < remain_elements.length;ii++) {
						
						menus[i].innerHTML += remain_elements[ii].outerHTML;
					}
					
					let more_element = document.createElement("li");
					more_element.className = "dropdown-toggle menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children dropdown menu-item-18 nav-item";
				
					more_element_link = document.createElement("a");
			
					more_element_link.innerHTML = "More";
				
					more_element.appendChild(more_element_link);
					
					more_element_list = document.createElement("ul");
					
					more_element_list.className = "sub-menu";
					
					for(let ii = 0;ii < cutten_elements.length;ii++) {
						
						more_element_list.innerHTML += cutten_elements[ii].outerHTML;
					}
					
					more_element.appendChild(more_element_list);
					
					menus[i].appendChild(more_element);
				}else if((menus[i].clientWidth / menusItems.count[i]) >= 100) {
					
					usingMore = false;
					
					menu.innerHTML = menusItems.items[i];
				}
			}
			
			navWalker();
		}else {
			
			usingMore = false;
		}
	}

	function navWalker() {
	
		/* Menu Nav Walker */
		$(".sub-menu").addClass("dropdown-menu").hide();
		$(".sub-menu").parent().addClass("dropdown-toggle");

		$(".dropdown-toggle > a").attr('href','').off('click');

		$('.dropdown-toggle > a').on('click',function(e){
			
			e.preventDefault();
			
			$(this).parent().siblings('.dropdown-toggle').find('.sub-menu').hide();

			$(this).siblings(".sub-menu").toggle();
		});
	}

	window.onresize = function() {

		menu_more_list();
	};

	//Window Element.
	$('.bw-window .layout,.bw-close-window').click((e) => {
		
		let $window = $(e.currentTarget).parent();
		
		if($(e.currentTarget).hasClass('bw-close-window'))
			$window = $window.parent();
		
		$window.fadeOut();
	});

	window.onload = function(){ 
		
		$("#loading").fadeOut();

		menu_more_list();
		
		navWalker();
	};

})(jQuery);