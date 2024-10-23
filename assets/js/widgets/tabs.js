(function($){
	
	$('.tabs-widget').each((ind,ele) => {
		
		$(ele).find(".tab-head [id*='tab-']").click((e) => {
		
			const lastTab = $(e.currentTarget).siblings(".active");
			
			lastTab.removeClass('active');
			
			const lastInd = lastTab.length == 0 ? -1:Number(lastTab[0].id.split('-')[1]);
			
			$(ele).find("#tab-"+ lastInd +"-content").removeClass("active");
			
			e.currentTarget.className = "active";
			
			$(ele).find("#tab-"+ Number(e.currentTarget.id.split('-')[1]) +"-content").addClass("active");
		});
	});
	
	$("#tabs-left,#tabs-right").click((e) => {
		
		const tabParent = e.currentTarget.parentElement.parentElement;
		const tabsCount = tabParent.attributes['tabs-count'].value;
		
		const currentTab = $(tabParent).find("[id^='tab-'].active");
		
		currentTab.removeClass("active");
		
		let moveTo = currentTab.length == 0 ? -1:Number(currentTab[0].id.split('-')[1]);
		if(e.currentTarget.id.split("-")[1] == 'left')
			moveTo = (moveTo - 1) < 0 ? tabsCount - 1:moveTo - 1;
		else
			moveTo = (moveTo + 1) >= tabsCount ? 0:moveTo + 1;

		$(tabParent).find("#tab-"+ moveTo +",#tab-"+ moveTo +"-content").addClass("active");
	});
})(jQuery);