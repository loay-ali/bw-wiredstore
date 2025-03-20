<?php

global $wp_customize;

$wp_customize->add_section('bw-top-row',array(
	'title' 		=> __("Top Row",'bw'),
	'description' 	=>__("Top Row Section Styling Customization",'bw'),
	'panel'			=> 'bw-theme-panel'
));

//Enable | Disable
$wp_customize->add_setting('bw-enable-top-row',array('default' => true));
$wp_customize->add_control('bw-enable-top-row',array(
	'setting'	=> 'bw-enable-top-row',
	'label'		=> __("Enable"),
	'type'		=> 'checkbox',
	'section' 	=> 'bw-top-row'
));

//Foreground Color
$wp_customize->add_setting('bw-top-row-fg',array('default' => '#000'));
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'bw-top-row-fg',
		array(
			'label'		=> __("Color"),
			'section'	=> 'bw-top-row'
		)
	)
);

//Background Color
$wp_customize->add_setting('bw-top-row-bg-color',array('default' => '#FFF'));
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'bw-top-row-bg-color',
		array(
			'label'		=> __("Background Color"),
			'section'	=> 'bw-top-row'
		)
	)
);

//Background Image
$wp_customize->add_setting('bw-top-row-bg-image');
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'bw-top-row-bg-image',
		array(
			'label'		=> __("Background Image"),
			'section'	=> 'bw-top-row'
		)
	)
);

//Size
$wp_customize->add_setting('bw-top-row-bg-size',array('default' => 'cover'));
$wp_customize->add_control('bw-top-row-bg-size',array(
	'label'		=> __("Background Size"),
	'type'		=> 'select',
	'section' 	=> 'bw-top-row',
	'choices' 	=> array(
		'cover'		=> __("Cover"),
		'contain'	=> __("Contain"),
		'100% 100%'	=> __("Full")
	)
));

//Position
$wp_customize->add_setting('bw-top-row-bg-position-x');
$wp_customize->add_setting('bw-top-row-bg-position-y');
$wp_customize->add_control(
	new WP_Customize_Background_Position_Control(
	$wp_customize,
	'bw-top-row-bg-position',
	array(
		'settings'	=> array('x' => 'bw-top-row-bg-position-x','y' => 'bw-top-row-bg-position-y'),
		'label'		=> __("Background Position"),
		'section' 	=> 'bw-top-row'
	)
));

//Repeat
$wp_customize->add_setting('bw-top-row-bg-repeat',array('default' => 'no-repeat'));
$wp_customize->add_control('bw-top-row-bg-repeat',array(
	'label'		=> __("Background Repeat"),
	'type'		=> 'select',
	'section' 	=> 'bw-top-row',
	'choices' 	=> array(
		'no-repeat'		=> __("No Repeat",'bw'),
		'repeat'		=> __("Repeat"),
		'repeat-x'		=> __("Repeat Horizontally",'bw'),
		'repeat-y'		=> __("Repeat Vertically",'bw'),
	)
));

//Attachment
$wp_customize->add_setting('bw-top-row-bg-attachment');
$wp_customize->add_control('bw-top-row-bg-attachment',array(
	'label'		=> __("Background Sticky",'bw'),
	'type'		=> 'select',
	'section' 	=> 'bw-top-row',
	'choices' 	=> array(
		'scroll'	=> __("Scroll"),
		'fixed'		=> __("Fixed"),
	)
));

//Opacity
$wp_customize->add_setting('bw-top-row-bg-opacity',array('default' => 1));
$wp_customize->add_control('bw-top-row-bg-opacity',array(
	'label' 		=> __("Opacity"),
	'type'			=> 'range',
	'section'		=> 'bw-top-row',
	'input_attrs'	=> array('min' => 0,'max' => 100)
	)
);

?>