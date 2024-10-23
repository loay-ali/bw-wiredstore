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
	'auto'	  =>__("Auto",'bw'),
	'cover'   =>__("Cover",'bw'),
	'contain' =>__("Contain",'bw'),
	'100%'	  =>__("Fill",'bw'));

/* Widgets Default Settings */

$wp_customize->add_panel('widgets-default',array(
	'title' => __("Widgets Default",'bw'),
	'description' => __("Setup Your Default Widget's Settings",'[domina]'),
	'priority'	=> 160
));

$wd_panels = array('basic-section','grid','statistics','tabs');

/* Add Sections & Common Settings ( In All Widgets ) */

foreach($wd_panels as $panel) {

	$wp_customize->add_section("bw-". $panel ."-widget",array(
		'panel' => 'widgets-default',
		'title' => __(ucfirst($panel)." Widget",'bw')
	));

	$panel_prefix = "bw-". $panel[0];
	$panel_section = "bw-". $panel ."-widget";

	//Text Color.
	$wp_customize->add_setting($panel_prefix ."-txt-color",array('default' => '#000'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$panel_prefix .'-txt-color',array(

		'label' => __("Text Color",'[domin]'),
		'section' => $panel_section
	)));

	//Background Color.
	$wp_customize->add_setting($panel_prefix ."-bg-color",array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color'
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$panel_prefix .'-bg-color',array(
		'label' => __("Background Color",'bw'),
		'section' => $panel_section
	)));

	//Background Image.
	$wp_customize->add_setting($panel_prefix ."-bg-image");
	$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize,$panel_prefix .'-bg-image',array(
		'label' => __("Background Image",'bw'),
		'mime_type' => 'image',
		'section' => $panel_section
	)));

	//Background Size.
	$wp_customize->add_setting($panel_prefix .'-bg-size',array('default' => 'auto'));
	$wp_customize->add_control($panel_prefix .'-bg-size',array(
		'label' 	=> __("Background Size",'bw'),
		'type'		=> 'select',
		'section'	=> $panel_section,
		'choices' 	=> $background_sizes
	));

	//Background Position.
	$wp_customize->add_setting($panel_prefix .'-bg-pos',array('default' => 'center center'));
	$wp_customize->add_control($panel_prefix .'-bg-pos',array(
		'label' 	=> __("Background Position",'bw'),
		'section' 	=> $panel_section,
		'type' 		=> 'select',
		'choices'	=> $background_positions
	));

	//Background Opacity.
	$wp_customize->add_setting($panel_prefix .'-bg-opacity',array('default' => 100));
	$wp_customize->add_control($panel_prefix .'-bg-opacity',array(
		
		'label' 		=> __("Background Opacity",'bw'),
		'section'		=> $panel_section,
		'type'			=> 'range',
		'input_attrs'	=> array(
		
			'min'	=> '0',
			'max'	=> '100',
			'step'	=> '1'
		)
	));

	//Background Attachment (Scrolling Effect).
	$wp_customize->add_setting($panel_prefix ."-bg-atta",array('default' => false));
	$wp_customize->add_control($panel_prefix .'-bg-atta',array(
		'label' 	=> __("Scrolling Effect",'bw'),
		'section'	=> $panel_section,
		'type' 		=> 'checkbox'
	));
	
	//Appear On Scroll.
	$wp_customize->add_setting($panel_prefix .'-appear-on-scroll',array('default' => false));
	$wp_customize->add_control($panel_prefix .'-appear-on-scroll',array(
		'label' 	=> __("Appear On Scroll",'[domin]'),
		'section' 	=> $panel_section,
		'type'		=> 'checkbox'
	));
	
	//Appear Effect.
	$wp_customize->add_setting($panel_prefix .'-appear-effect',array('default' => 'fade'));
	$wp_customize->add_control($panel_prefix .'-appear-effect',array(
		
		'label' 	=> __("Appear Effect",'bw'),
		'section'	=> $panel_section,
		'type' 		=> 'select',
		'choices' 	=> array(
		
			'none' 	=> __("None",'bw'),
			'fade'	=> __("Fade",'bw'),
			'slide'	=> __("Slide",'bw'),
			'flip'	=> __("Flip",'bw')
		)
	));
	
	//Appear From.
	$wp_customize->add_setting($panel_prefix .'-appear-from',array('default' => 'left'));
	$wp_customize->add_control($panel_prefix .'-appear-from',array(
		
		'label' 	=> __("Appear From",'bw'),
		'section'	=> $panel_section,
		'type'		=> 'select',
		'choices'	=> array(
			
			'left'	=> __("Left",'bw'),
			'top'	=> __("Top",'bw'),
			'right'	=> __("Right",'bw'),
			'bottom'=> __("Bottom",'bw')
		)
	));
}

/* Grid Widget */

//Each Grid Settings

//Background Color.
$wp_customize->add_setting('bw-g-grid-bg-color',array('default' => '#fff'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'bw-g-grid-bg-color',array(

	'label' 	=> __("Grid Background Color",'bw'),
	'section'	=> 'bw-grid-widget'
)));

//Text Color.
$wp_customize->add_setting('bw-g-grid-txt-color',array('default' => '#000'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'bw-g-grid-txt-color',array(

	'label'		=> __("Grid Text Color",'bw'),
	'section'	=> 'bw-grid-widget'
)));

//Vertical Scroll.
$wp_customize->add_setting('bw-g-vertical-scroll',array('default' => false));
$wp_customize->add_control('bw-g-vertical-scroll',array(

	'label'		=> __("Vertical Scroll",'bw'),
	'section'	=> 'bw-grid-widget',
	'type'		=> 'checkbox' ));

/* Tabs Widget */

//Switch Effect.
$wp_customize->add_setting('bw-t-switch-effect',array('default' => 'none'));
$wp_customize->add_control('bw-t-switch-effect',array(
	
	'label' 	=> __("Switch Effect",'bw'),
	'section'	=> 'bw-tabs-widget',
	'type'		=> 'select',
	'choices'	=> array(
		
		'none'	=> __("None",'bw'),
		'slide'	=> __("Slide",'bw'),
		'fade'	=> __("Fade",'bw'),
		'flip'	=> __("Flip",'bw')
	)
));

/* Statistics Widget */
//Each Stat.
//Background Color.
$wp_customize->add_setting("bw-s-stat-bg-color",array('default'	=> '#fff'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'bw-s-stat-bg-color',array(
	
	'label' 	=> __("Stat Background Color",'bw'),
	'section'	=> 'bw-statistics-widget'
)));

//Text Color.
$wp_customize->add_setting("bw-s-stat-txt-color",array('default' => '#000'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'bw-s-stat-txt-color',array(
	
	'label' 	=> __("Stat Text Color",'bw'),
	'section'	=> 'bw-statistics-widget'
)));
?>