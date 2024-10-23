(function($){
	
	//Mini Cart.
	$(".cart-toggle , .cart-close").click(function(e){
		
		$(".cart-toggle").toggleClass('active');
		$(".cart-container").toggleClass('active');
	});
	
	//Switch Between Login & Register.
	$(".bw-wc-switch-login").click(function(){
		
		$("#bw-wc-login,#bw-wc-register").toggle();
	});
	
	//Repeat Password Field.
	$("#reg_password_re").blur(function(){
		
		if($(this).val() != $("#reg_password").val()) {
			
			$(this).addClass('invalid');
		}else {
			
			$(this).removeClass('invalid');
		}
	});
	
	//Category List.
	$(".cat-parent").click(function(e){
		
		if(e.target.nodeName != "A") {
		
			$(this).find(">.children").toggle();
			$(this).toggleClass('opened');
		}
	});
	
	//To Shipping Form.
	$("#to-shipping-form , #to-billing-form").click(function(e){
		
			$("#checkout-stages button:first-of-type").toggleClass("active");
			$("#checkout-stages button:last-of-type").toggleClass("active");
			
			$("#customer_details div:first-of-type").toggleClass('active');
			$("#customer_details div:last-of-type").toggleClass('active');
			
			$("html").animate( { 'scrollTop':document.getElementById("checkout-stages").offsetTop - 200},0 );
	});
	
	//Navigation Menu Toggle.
	$(".toggle-myaccount-menu").click(function(){
		
		$(this).siblings("nav").slideToggle();
	});
})(jQuery);