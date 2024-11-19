<?php 
global $wp_customize;

$background_positions = array(
	"center top"	=>__("Top",'bw'),
	"center bottom" =>__("Bottom",'bw'),
	"center center" =>__("Center",'bw'),
	"left top" 		=>__("Left Top Corner",'bw'),
	"left bottom" 	=>__("Left Bottom Corner",'bw'),
	"left center" 	=>__("Left Center",'bw'),
	"right top" 	=>__("Right Top Corner",'bw'),
	"right bottom"  =>__("Right Bottom Corner",'bw'),
	"right center"  =>__("Right Center",'bw'));
$background_sizes = array(
	'cover'   =>__("Cover",'bw'),
	'contain' =>__("Contain",'bw'),
	'100%'	  =>__("Fill",'bw'));

/* Header Section */
$wp_customize->add_section("header-section",array(

	'title' 		=>__("Header",'bw'),
	'description' 	=>__("Header Section Styling Customization",'bw'),
	'panel'			=> 'bw-theme-panel'
));

//Title.
$wp_customize->add_setting("header-title",array('sanitize_callback'=>'esc_html'));
$wp_customize->add_control("header-title",array(

	'label'		=> __("Title",'bw'),
	'section'	=> 'header-section'));

//Logo Appearance.
$wp_customize->add_setting("header-logo-display",array('default'=>true, 'sanitize_callback'=>'rest_sanitize_boolean'));
$wp_customize->add_control("header-logo-display",array(
	"label"=>__("Display Header's Logo",'bw'),
	"type"=>"checkbox",
	'section'=>"header-section"));

//Background Color.
$wp_customize->add_setting("header-bg-color",array('default'=>'#fff', 'sanitize_callback'=>'sanitize_hex_color'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'header-bg-color',array(
	"label"=>__("Background Color",'bw'),
	"section"=>"header-section")));

//Opacity.
$wp_customize->add_setting("header-opacity",array('default' => 1));
$wp_customize->add_control("header-opacity",array(
	"label" =>__("Opacity",'bw'),
	"section" =>"header-section",
	"type" =>"range",
	"input_attrs" => array("min"=> 0,'max'=> 1,'step'=> 0.1) ));
	
//Background Image.
$wp_customize->add_setting("header-bg-image",array('sanitize_callback'=>'esc_url'));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,"header-bg-image",array(
	"label"=>__("Background Image",'bw'),
	"section"=>"header-section" )));
	
//Background Image Size.
$wp_customize->add_setting("header-bg-image-size",array('default'=>'cover', 'sanitize_callback'=>'esc_html'));
$wp_customize->add_control("header-bg-image-size",array(
	"label"=>__("Background Size",'bw'),
	"type"=>"select",
	"section"=>"header-section",
	"choices"=>$background_sizes));
		
//Background Image Position.
$wp_customize->add_setting("header-bg-image-position",array('default'=>"center center",'sanitize_callback'=>'esc_html'));
$wp_customize->add_control("header-bg-image-position",array(
	"label"=>__("Background Positon",'bw') ,
	'section'=>"header-section" ,
	'type'=>'select' ,
	'choices'=>$background_positions));

//Scrolling Effect ( Background Attachment )
$wp_customize->add_setting("header-bg-attachment",array('default'=>false,'sanitize_callback'=>'rest_sanitize_boolean'));
$wp_customize->add_control("header-bg-attachment",array(
	'label'=>__("Background Scrolling Effect",'bw'),
	'type'=>'checkbox' ,
	'section'=>'header-section'));
	
$options = array(

	'toggle-effect'	=> array(
	
		'none'	=> __("None",'bw'),
		'fade'	=> __("Fade",'bw'),
		'slide'	=> __("Slide",'bw'),
		'flip'	=> __("Flip",'bw')
	)
);

//Toggle Effect.
$wp_customize->add_setting('bw-menu-toggle-effect',array('default' => 'none'));
$wp_customize->add_control('bw-menu-toggle-effect',array(

	'label'		=> __("Toggle Effect",'bw'),
	'section'	=> 'header-section',
	'type'		=> 'select',
	'choices'	=> $options['toggle-effect']
));
	
?>