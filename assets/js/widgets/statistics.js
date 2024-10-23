(function($) {

	let stats = document.querySelectorAll(".stat-widget");
	let curr_stat = 0;
  
	let statIntervals = [];
	let counters = [];
	let stat_index = 0;
  
	function snap(destination) {
		if (Math.abs(destination - window.scrollY) < (window.innerHeight / 2)) {
			
			let stat_list = stats[curr_stat].children[1].children;
			
			for(let i = 1;i < stat_list.length;i++) {
				
				let stat_element = $(stat_list[i]).find(".stat-number")[0];
				let stat_number = Number(stat_element.innerHTML);
				
				let percentNum = false;
				
				stat_text = stat_element.innerHTML.trim();
				
				//Check If It's a Percent Number.
				if(stat_text.indexOf("%") != -1) {
					
					stat_number = Number(stat_text.substr(0,stat_text.length - 2));
					percentNum = true;
				}
				
				let curr_index = Number((i - 1) + stat_index);
				
				counters.push(0);
				
				statIntervals.push(setInterval(function(){
				
					counters[curr_index]++;
					
					if(percentNum == false) {
						
						stat_element.innerHTML = counters[curr_index];
					}else {
						stat_element.innerHTML = counters[curr_index] + " %";
					}
					
					if(counters[curr_index] >= stat_number) {
						
						clearInterval(statIntervals[curr_index]);
					}
				},1));
			}
			stat_index = stat_list.length - 1;
			curr_stat++;
		}
    }
    var timeoutId = null;

	addEventListener("scroll", function() {
        if ( timeoutId ) clearTimeout(timeoutId);
        if (curr_stat >= stats.length) { return; }
		timeoutId = setTimeout(snap, 200, parseInt(stats[curr_stat].offsetTop - (stats[curr_stat].offsetHeight/2)));
    }, true);

})(jQuery);