<?php

//Loading Screen
function bw_loading_screen() {
	$bw_template = get_theme_mod('bw-loading-screen-template','3-dots');
	switch( $bw_template ) {

		case '3-dots':
		case 'spinning-dots':
		case 'lingar-bar':

			echo file_get_contents(get_template_directory_uri() .'/templates/loadings/'. $bw_template .'.html');
		break;
	}
}

/* Include Scripts and Stylesheets */
function bw_include_theme_scripts () {
	
	$js_dir = get_template_directory_uri() . '/assets/js/';
	$css_dir = get_template_directory_uri() . '/assets/css/';

	//Font Awesome Library.
	wp_enqueue_style("fontawesome",get_template_directory_uri() . "/assets/fonts/fontawesome/css/all.min.css",array(),'1.0.0');
	
	//Main Stylesheet.
	wp_enqueue_style("style",get_stylesheet_uri('style.css'));

	//Smart Watch Styling.
	wp_enqueue_style('bw-smartwatch-style',$css_dir .'smart-watch.css',array(),false,'(max-width:250px)');

	//Admin Styling.
	if( is_admin_bar_showing() )	
		wp_enqueue_style("admin-style",$css_dir ."admin.css");

	//Register Minified Jquery Version ( Higher Performance ).
	wp_deregister_script('jquery');
	wp_register_script('jquery',$js_dir . 'jquery.min.js',false,'3.5.1',true);
	
	//Main JavaScript File.
	wp_enqueue_script("option",$js_dir."main.js",array('jquery'),false,true);

	// Widgets Scripts.
	$widget_script_dir = $js_dir."widgets/";
	
	//Grid Section's Script.
	if(is_active_widget(false,false,'grid_section')) {
		
		wp_enqueue_script("grid-script",$widget_script_dir."grid.js",array('jquery'),false,true);
	}
	
	//Statistics Script.
	if(is_active_widget(false,false,'se_statistics_widget')) {
		
		wp_enqueue_script("statistics-script",$widget_script_dir."statistics.js",array('jquery'),false,true);
	}
	
	//Slideshow Script.
	if(is_active_widget(false,false,'se_slideshow_widget')) {
		
		wp_enqueue_script('slide-script',$widget_script_dir."slideshow.js",array('jquery'),false,true);
	}
	
	//Tabs Scripts.
	if(is_active_widget(false,false,'se_tabs_widget')) {
		
		wp_enqueue_script('tabs-script',$widget_script_dir."tabs.js",array('jquery'),false,true);
	}
	
	//Font Link ( Google Fonts ).
	$fontLink = bw_get_font_url();
	if( $fontLink != false ) {
		
		wp_enqueue_style('font-script',$fontLink,array(),false);
	}
}

function bw_get_font_name() {
	
	$main_choice = get_theme_mod('bw-google-fonts-choice','');
	if( $main_choice != false )
		return $main_choice;

	if( get_theme_mod('bw-fonts-use-url',false) == false )
		return get_theme_mod('bw-font-name',false);
	
	$parsedLink = get_theme_mod('bw-font-url',false);
	
	if( $parsedLink == false )
		return false;
	
	$parsedLink = parse_url($parsedLink)['query'];
	
	if( $parsedLink == array() ) 
		return false;
	
	$tmpLink = null;
	parse_str($parsedLink,$tmpLink);
	
	return explode(':',$tmpLink['family'])[0];
}

function bw_get_font_url() {
	
	if( get_theme_mod('bw-fonts-use-url',false) == true) {
		
		return get_theme_mod('bw-font-url',false/* No URL Fallback */);
	}
	
	//Check Font Name Exists.
	$bwFontName = get_theme_mod('bw-font-name','');
	$bwFontChoice = get_theme_mod('bw-google-fonts-choice','');

	if( $bwFontChoice == '' && $bwFontName == '' )
		return false;
	
	$url = "https://fonts.googleapis.com/css?";
	
	//Font Name.
	$url .= 'family='. str_replace(' ','+', $bwFontChoice == '' ? $bwFontName:$bwFontChoice);	
	
	$bold = get_theme_mod('bw-font-is-bold',false);
	$italic = get_theme_mod('bw-font-is-italic',false);
	
	//Styles.
	if( $bold == true && $italic == true ) { /* Bold + Italic */
			
		$url .= ":bi";
	
	}elseif( $bold == false && $italic == true ) { /* Italic Only */
		
		$url .= ":i";
			
	}elseif( $bold == true && $italic == false ) { /* Bold Only */
		
		$url .= ":b";
	}
	
	//Subset.
	$subset = get_theme_mod('bw-font-subset','');
	if( $subset != '' )
		$url .= "&subset=". $subset;
	
	return $url;
}

/* Applying Styling To The Page. */
function bw_apply_style () {
	echo "<style>";
	
		//Define Main Variables
		echo ':root {';
			echo '--bw-border-radius: '. implode(' ',array_map(function($ele) { return get_theme_mod('bw_border_radius_'. $ele,0) .'px';},['top','right','bottom','left'])) .';';
			
			echo '--bw-foreground-color:'. get_theme_mod('bw_color_'. get_theme_mod('bw_foreground_color',''),'#000') .';';
			echo '--bw-primary-color:'. get_theme_mod('bw_color_'. get_theme_mod('bw_primary_color',''),'#FFF') .';';
			echo '--bw-secondary-color:'. get_theme_mod('bw_color_'. get_theme_mod('bw_secondary_color',''),'#DDD') .';';
			
			echo '}';

		//Headings.
		foreach( array(1,2,3,4,5,6) as $heading ) {
			echo 'h'. $heading .' {';
				echo 'font-size:'. get_theme_mod('bw_font_size_heading_'. $heading,16) .'px;';
			echo '}';
		}

		//Font.
		echo "*:not(.fas,.fa,.fab,.far,#wpadminbar *,.ab-icon) {";
		
			$fontName = bw_get_font_name();
		
			echo "font-family:". $fontName .",san-serif !important;";
			echo "font-size:". get_theme_mod('bw_font_size_default','14') .'px;';
		echo "}";
	
		//Header.
		echo "#main-header {";
		
			echo "background-color:". get_theme_mod('header-bg-color','#fff') .";";
			echo "opacity:". get_theme_mod('header-opacity',1) .";";
			if(get_theme_mod('header-bg-image')) {
				echo "background-image:url(". get_theme_mod('header-bg-image') .");";
				echo "background-position:". get_theme_mod("header-bg-image-position",'center center') .";";
				echo "background-size:". get_theme_mod("header-bg-image-size",'cover') .";";
			}
			if(get_theme_mod('header-bg-attachment')) {
				if(get_theme_mod('header-bg-attachment') == true) {
					echo "background-attachment:fixed;";
				}
			}
	
		echo "}";
		
		echo "#header-menu {";
		
			echo "background-color:". get_theme_mod("header-bg-color",'#fff') .";";
		
		echo "}";
		
		echo "#main-header * {";
		
			echo "color:". get_theme_mod('txt-color-1','#000') .";";
	
		//End Header.
		echo "}";
		
		//Links Color.
		echo "a[href]{color:". get_theme_mod('link-color','#444') .";}";

		//Custom Background Color & Opacity
		echo "body.custom-background:after {";
			
			echo "content:'';position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;";
			echo "background-color:". get_theme_mod("background-color",'#ffffff').";";
			echo 'opacity:'. get_theme_mod("background-color-opacity",100) / 100 .";";
		
		echo "}";
		
		//Footer.
		echo "#main-footer {";
		
			echo "color:" . get_theme_mod('txt-color-1','#000') .";";
			echo "background-color:". get_theme_mod('footer-bg-color','#fff') .";";
			if(get_theme_mod('footer-bg-image')) {
				echo "background-image:url(". get_theme_mod('footer-bg-image') .");";
				echo "background-position:". get_theme_mod('footer-bg-image-position','center center') .";";
				echo "background-size:". get_theme_mod('footer-bg-image-size','cover') .";";
				if(get_theme_mod('footer-bg-attachment')){
					if(get_theme_mod('footer-bg-attachment') == true) {
						echo "background-attachment:fixed;";
					}
				}
			}
		
		echo "}";
	echo "</style>";
}

/* Fonts Setting's Page */
add_action('admin_menu',function(){
	
	add_options_page(
		__("Google Fonts",'bw'),
		__("Fonts",'bw'),
		'manage_options',
		'bwbw_google-fonts-page',
		function() { require __DIR__ ."/inc/settings-fonts.php";}
	);
});

/* Register Menus */
function bw_register_nav_menus () {
	register_nav_menus(array(
		"primary" 	=> __("Primary Menu",'bw'),
		"social" 	=> __("Social Media Links",'bw'),
		"phone"		=> __("Phone Numbers",'bw')));
}

/* Register Sidebars */
function bw_register_widgets () {
	
	//Header Widgets. ( 2 Widgets )
	for($w = 1;$w <= 2;$w++) {
		register_sidebar(array(
			"id" 			=> "header-" . $w,
			"name" 			=> __("Header " . $w,'bw'),
			"description" 	=> __("Widget Number $w In The Header",'bw'),
			'before_widget' => '',
			'after_widget'	=> ''
		));
	}
	
	//Home Page Widgets ( 4 Widgets ).
	for($w = 1;$w <= 4;$w++) {
		register_sidebar(array(
			"id" 			=> "home-" . $w,
			"name" 			=> __("Home $w Widget",'bw'),
			"description" 	=> __("Widget Number $w In The Home Page",'bw')));
	}
	
	//Footer Widgets. ( 3 Widgets )
	for($w = 1;$w <= 3;$w++) {
		register_sidebar(array(
			"id" 			=> "footer-" . $w,
			"name" 			=> __("Footer " . $w,'bw'),
			"description" 	=> __("Widget Number $w In The Footer",'bw'),
			'before_widget'	=> '',
			'after_widget'	=> ''));
	}
	
	//Sidebar Widget.
	register_sidebar(array(
		"id" 			=> "sidebar",
		"name" 			=> __("Sidebar",'bw'),
		"description" 	=> __("The Widget Of The Sidebar",'bw')
	));
	
	//Widgets Tools.
	require __DIR__ ."/inc/widgets/tools.php";
	
	//Include Normal Section Widget.
	get_template_part("inc/widgets/section");
	
	//Include Grid Section Widget.
	get_template_part("inc/widgets/grid");
	
	//Include Slideshow Widget.
	get_template_part("inc/widgets/slideshow");
	
	//Include Statistics Widget.
	get_template_part("inc/widgets/statistics");
	
	//Include Tabs Widget.
	get_template_part("inc/widgets/tabs");
	
	//Include Contact Info.
	get_template_part("inc/widgets/contact");
}

/* Theme Supports */
function bw_theme_supports () {
	
	//Post Thumbnail.
	add_theme_support("post-thumbnails");
	
	//Site Logo.
	add_theme_support("custom-logo");
	
	//Cutom Title.
	add_theme_support("title-tag");
	
	//Background.
	add_theme_support("custom-background");
}

function bw_plugins_addition_include () {
	
	if(class_exists('woocommerce',false)) { get_template_part("inc/woocommerce/class-woocommerce"); }
	
	if(class_exists('Jetpack')) { get_template_part('inc/jetpack/class-jetpack');}
}

//Include Stylesheets & Scripts.
add_action("wp_enqueue_scripts","bw_include_theme_scripts");

//Register Menus.
add_action("after_setup_theme","bw_register_nav_menus");

//Additional Plugins Functionality.
add_action("after_setup_theme",'bw_plugins_addition_include');

//Register Sidebars.
add_action("widgets_init","bw_register_widgets");

//Admin Scripts ( For Widgets ).
add_action("admin_enqueue_scripts",function(){
	wp_enqueue_media();
	wp_enqueue_script("media_uploader",get_template_directory_uri() ."/js/media_uploader.js",array('jquery','wp-color-picker'),false,true);

	wp_enqueue_style('wp-color-picker');

	if( is_customize_preview() )
		wp_enqueue_style( 'bw-customize-styling', get_template_directory_uri(  ) .'/assets/css/customize.css' );
});

//Customize API.
add_action("customize_register",function() {
	
	$prefix = 'bw_';
	
	get_template_part("inc/customize/header");
	get_template_part("inc/customize/colors");
	get_template_part("inc/customize/border-radius");
	get_template_part("inc/customize/background-image");
	get_template_part("inc/customize/widgets-default");
	get_template_part("inc/customize/footer");
	get_template_part("inc/customize/site-identity");
	get_template_part("inc/customize/google-fonts");
	get_template_part("inc/customize/icons-library");
	get_template_part("inc/customize/loading-screen");
	get_template_part("inc/customize/menu");
});

//Contect Post Type ( Used For Assigning Content Into Your Widgets ).
add_action('init',function(){
	
	register_post_type('content',array(
	
		'label' 			=> __('Content','bw'),
		'description' 		=> __('Manage The Content Of Your Widgets','bw'),
		'show_ui' 			=> true,
		'menu_position' 	=> 6,
		'menu_icon' 		=> 'dashicons-welcome-widgets-menus',
		'supports' 			=> array('title','editor'),
		'query_var' 		=> false,
		'delete_with_user' 	=> false
	));
});

/* Disable the emoji's */
add_action( 'init',function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
});

//Excerpt.
add_filter("excerpt_length",function($len) {return 20;});
add_filter("excerpt_more",function($more) {return "<u> ,".__("...Read More",'bw')."</u>";});

//Applying Style.
add_action("wp_head","bw_apply_style");

//Theme Supports.
add_action("after_setup_theme","bw_theme_supports");
?>
