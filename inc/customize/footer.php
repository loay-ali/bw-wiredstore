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

/* Footer Section */

$wp_customize->add_section("footer-section",array(
	"title" => __("Footer"),
	"description" => __('Footer Section Styling Customization','bw')));

//Background Color
$wp_customize->add_setting("footer-bg-color",array('default' => "#fff",'sanitize_callback' => 'sanitize_hex_color'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,"footer-bg-color",array(
	"label" => __("Background Color",'bw') ,
	"section" => "footer-section" )));

//Background Image.
$wp_customize->add_setting("footer-bg-image",array('sanitize_callback' => 'esc_url'));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,"footer-bg-image",array(
	"label" => __("Background Image",'bw'),
	"section" => "footer-section" )));
	
//Background Image Size.
$wp_customize->add_setting("footer-bg-image-size",array('default' => 'cover','sanitize_callback' => 'esc_html'));
$wp_customize->add_control("footer-bg-image-size",array(
	"label" => __("Background Size",'bw'),
	"type" => "select",
	"section" => "footer-section",
	"choices" => $background_sizes));
		
//Background Image Position.
$wp_customize->add_setting("footer-bg-image-position" , array( 'default' => "center center",'sanitize_callback' => 'esc_html'));
$wp_customize->add_control("footer-bg-image-position",array(
	"label" => __("Background Positon",'bw') ,
	'section' => "footer-section" ,
	'type' => 'select' ,
	'choices' => $background_positions));

//Scrolling Effect ( Background Attachment )
$wp_customize->add_setting("footer-bg-attachment",array('default' => false,'sanitize_callback' => 'rest_sanitize_boolean'));
$wp_customize->add_control("footer-bg-attachment",array(
	'label' => __("Background Scrolling Effect",'bw') ,
	'type' => 'checkbox' ,
	'section' => 'footer-section'));
?>