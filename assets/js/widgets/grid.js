(function($){
	
	//Check The Width Of The Window.
	const the_width = window.innerWidth;
	const main_grid = $(".main-grid");
	
	//The current Grid.
	let curr_grid = [];
	let max_grid = [];
	
	if(main_grid.length != 0) {
	
		//Loop Inside Each Grid Element.
		main_grid.each((ind,ele) => {
			
			let the_container_width;
			const number_of_grids = Number($(ele).attr('num-of-grids'));
			
			curr_grid.push(0);
			max_grid.push(0);
			
			const grid_numbers = $(ele).parent().find('.grid-numbers');
			
			$(main_grid[ind]).siblings('.grid-move').attr('bw-grid-ind',ind);
			
			if( the_width < 576 ) { the_container_width = number_of_grids * 100;max_grid[ind] = number_of_grids; }
			else if(the_width >= 576 && the_width < 768) { the_container_width = (number_of_grids / 2) * 100;max_grid[ind] = Math.ceil(number_of_grids / 2); }
			else if(the_width >= 768 && the_width < 992) { the_container_width = (number_of_grids / 3) * 100;max_grid[ind] = Math.ceil(number_of_grids / 3); }
			else if(the_width >= 992 && the_width < 1200) { the_container_width = (number_of_grids / 4) * 100;max_grid[ind] = Math.ceil(number_of_grids / 4); }
			else { the_container_width = (number_of_grids / 5) * 100;max_grid[ind] = Math.ceil(number_of_grids / 5); }
			
			if(number_of_grids == 0) {
				
				the_container_width = 100;
				max_grid[ind] = 2;
			}
			
			max_grid[ind]--;
			
			if( max_grid[ind] == 0 ) {
			
				$(".grid-move").hide(); 

			}else {
				
				const grid_ele = $(ele).parent().find('.grid-numbers');
				for(let gn = 0;gn <= max_grid[ind];gn++) {
								
					grid_ele.append(
						$('<button></button')
							.attr('class','grid-numbers-btn'+ (gn == 0 ? ' active':''))
							.attr('id','grid-btn-'+ gn)
							.click(() => { move(gn,ind); })
					);
				}
			}
			
			the_container_width = (the_container_width > 100) ? the_container_width:100;
			
			main_grid[ind].style.width = the_container_width +"%";
			
			/* For Touch Devices Users */
			if( $(main_grid[ind]).attr('vertical-scroll') != 0 ) {
				
				let last_pos = 0;
				$(main_grid[ind]).bind("touchstart",(e) => {
					
					last_pos = e.changedTouches[0].clientX;
				});
					
				$(main_grid[ind]).bind("touchmove",(e) => {
						
					if((e.changedTouches[0].clientX - last_pos) < 100 && (e.changedTouches[0].clientX - last_pos) > -100) {
						
						e.currentTarget.style.left = "calc(" + (e.changedTouches[0].clientX - last_pos) +"px + "+ -(curr_grid[ind] * 100) +"%)";
					}
				});
				
					
				$(main_grid[ind]).bind("touchend",(e) => {
					
					let the_pos = e.changedTouches[0].clientX - last_pos;
					
					if(the_pos < -70) { cgf(1,ind); } 
					else if(the_pos > 70) { cgf(-1,ind); }

					last_pos = 0;
				});
			}
		
		});

		function cgf (to,ind) {
			
			curr_grid[ind] += to;
			
			if(curr_grid[ind] > max_grid[ind]) {curr_grid[ind] = 0;}
			else if( curr_grid[ind] < 0 ) {curr_grid[ind] = max_grid[ind];}

			move(curr_grid[ind],ind);
		}
		
		function move(to,ind = -1) {
		
			const gridSection = $($('.grid-section')[ind]);
		
			gridSection.find('.grid-numbers-btn.active').removeClass('active');
		
			curr_grid[ind] = to;
			
			main_grid[ind].style.left = (curr_grid[ind] * -100) +"%";
			
			gridSection.find('.grid-numbers-btn:nth('+ curr_grid[ind] +')').addClass('active');
		}

		//Moving Throught Grids.
		/* For Clicking Devices */
		$('.grid-move').each((ind,ele) => {
			
			$(ele).click((ele) => {
			
				const gridInd = Number($(ele.currentTarget).attr('bw-grid-ind'));
			
				if( ele.currentTarget.id == 'grid-move-right' ) { cgf(1,gridInd);}
				else { cgf(-1,gridInd);}
			});
		});
	}
	
})(jQuery);