<?php

class BW_Woocommerce {
	
	function __construct() {
		
		//Register Scripts.
		add_action("wp_enqueue_scripts",array($this,'register_scripts'));
		
		//Cart Element.
		add_action("bw_theme_main_container",array($this,'cart_element'));
		
		//Cart Counter
		add_filter('woocommerce_add_to_cart_fragments',array($this,'cart_counter'));
		
		//Notify Me Mechanism
		require_once __DIR__ .'/notify-me.php';

		//Theme Supports.
		$this->theme_support();
		
		//Checkout Page Tabs.
		add_action('woocommerce_checkout_before_customer_details',array($this,'checkout_page_tabs'));
	
		//Checkout ( Next ) Buttons - For Filling Form Stages -
		add_action("woocommerce_checkout_billing",array($this,'checkout_page_billing'),9999999);
	
		//Checkout ( Previous ) & ( Check Your Order ) Buttons - For Filling Form Stages -
		add_action("woocommerce_checkout_shipping",array($this,'checkout_page_shipping'),9999999);
	
		//Product Sale's Expire Time.
		add_action('woocommerce_single_product_summary',array($this,'sale_expire'));
	
		//Product OnSale Saving Rate.
		add_action('woocommerce_single_product_summary',array($this,'saving_rate'));

		//Q & A Front End.
		add_filter('woocommerce_product_tabs', array($this, 'qa_tab'));

		if( is_admin() ) {
			require_once __DIR__ .'/admin.php';
		}
	}
	
    function qa_frontend()
    {

        require_once __DIR__ . '/../../templates/qa.php';
    }

    function qa_tab($tabs)
    {

        $tabs['question-and-answers'] = array(

            'title'        => 'الأسئلة الشائعة',
            'priority'    => 900,
            'callback'    => array($this, 'qa_frontend')
        );

        return $tabs;
    }

	function saving_rate() {
		
		global $product;
		$salePrice = $product->get_sale_price();
		$price = $product->get_regular_price();
		
		if($salePrice != null):
			$saleRate = round(100 - (($salePrice / $price) * 100),2);
		?>
			<span style = 'display:block;margin:10px 0;'>
				<?php echo __("Saving ",'bw')."<strong>". $saleRate .'%</strong>';?>
			</span>
		<?php endif;
	}
	
	function register_scripts() {
		
		wp_enqueue_script('wc-plugin',get_template_directory_uri() ."/assets/js/woocommerce/wc-plugin-min.js",array('jquery'),false,true);
	}
	
	function cart_element() {
		
		if(!is_checkout() && !is_cart()):?>
		
			<section class = 'cart-container'>
				<button class = 'cart-toggle'>
					<i class = 'fas fa-shopping-cart'></i>
					<sup class = 'cart-amount red-btn'>
						<?php global $woocommerce;echo $woocommerce->cart->get_cart_contents_count();?>
					</sup>
				</button>
				<section class = 'cart-content'>
					<button class = 'phone-only cart-close red-btn'>
						<i class = 'fas fa-angle-double-right'></i>
					</button>
					<?php the_widget( 'WC_Widget_Cart', 'title=' );?>
				</section>
			</section>
			
	<?php endif; }
	
	function cart_counter($fragments) {
		
		$fragments['.cart-amount'] = "<sup class = 'red-btn cart-amount'>". WC()->cart->get_cart_contents_count() ."</sup>";
		return $fragments;
	}
	
	function theme_support() {
		
		add_theme_support("woocommerce");
		add_theme_support("wc-product-gallery-zoom");
		add_theme_support("wc-product-gallery-lightbox");
		add_theme_support("wc-product-gallery-slider");
	}
	
	function checkout_page_tabs () {?>
		
		<header id = 'checkout-stages'>
		
			<button type = 'button' class = 'active'>
				<b>1</b>
				<span>
					<?php _e("Billing details",'woocommerce');?>
				</span>			
			</button>
			
			<button type = 'button'>
				<b>2</b>
				<span>
					<?php _e("Additional information",'woocommerce');?>
				</span>
			</button>
		</header>
	
	<hr />		
	<?php }
	
	function checkout_page_billing () {?>

		<button class = 'primary-btn' type = 'button' id = 'to-shipping-form'>
			<?php _e("Next",'bw');?>
		</button>
	<?php }
	
	function checkout_page_shipping () {?>
	
		<button class = 'primary-btn' type = 'button' id = 'to-billing-form'>
			<?php _e("Back",'bw');?>
		</button>
		
		<a href = '#scroll#order_review_heading' class = 'button primary-btn'>
			<?php _e("Check Your Order",'bw');?>
		</a>		
	<?php }
	
	function sale_expire () {
		
		global $product;
		
		$expire = $product->get_date_on_sale_to();
		
		if($expire != null) {
		
			echo "<i class = 'fas fa-error'></i> " . __("Available Until ",'bw') . 
			"<time>". date("( Y / M / d )",strtotime($expire)) ."</time>";
		}		
	}
}


return new BW_Woocommerce;
?>