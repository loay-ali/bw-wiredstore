<?php

class BW_Jetpack {
	
	function __construct() {

		//Scripts.
		add_action('wp_enqueue_scripts',array($this,'scripts'));

		//Handle Share Buttons.
		add_action("bw-post-share",array($this,'sharing'));
		
		//Theme Support.
		$this->theme_support();
	}
	
	function scripts() {
		
		//Infinity Scroll Script (Never Ending)
		if( (class_exists('woocommerce',false) && is_shop())
		|| is_tax() ) {
			wp_enqueue_script('the-neverending-homepage');
		}
	}
	
	function sharing () {
		
		sharing_display('',true);
	}
	
	function theme_support() {
		
		add_theme_support('infinite-scroll',array(
		
			'container'	=> 'main',
			'footer'	=> 'main-container',
			'render'	=> array($this,'infinite_scroll_render'),
			'footer_widgets' => array('footer-1','footer-2','footer-3')
		));
	}
	
	function infinite_scroll_render() {
		
		//Check If It's Not Woocommerce Stuff.
		if( class_exists('woocommerce',false) ) {
			
			if(!is_shop()
			&& !is_product_taxonomy()
			&& !is_product_category()
			&& !is_product_tag()) {
				
				get_template_part('inc/post','thumbnail');
			}
		}
	}
}

return new BW_Jetpack;
?>