<?php 

global $wp_customize;

/* Site's Background Image ( If Theme Support It ) */

if(get_theme_support('custom-background')) {
	
	//Background Color ( On Top Of The Background Image )
	$wp_customize->add_setting('background-color',array(
		'default' 			=> '#fff',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'background-color',array(
		'label'		=> __("Background Color",'[domian]'),
		'section' 	=> 'background_image'
	)));
	
	//Color Opacity
	$wp_customize->add_setting('background-color-opacity',array(
		'default' 			=> 100,
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control('background-color-opacity',array(
		'label' 		=> __("Opacity",'bw'),
		'section' 		=> 'background_image',
		'type' 			=> 'range',
		'input_attrs' 	=> array(
			'min' 	=> 0,
			'max' 	=> 100,
			'step' 	=> 1
		)
	));
} ?>