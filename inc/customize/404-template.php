<?php

global $wp_customize;

//Section
$wp_customize->add_section('bw-404-template',array(
	'title' => __("404 Page Design",'bw'),
	'description' => __("Manage how 404 page will look and feels",'bw')
));

//-> Layout
$wp_customize->add_setting('bw-404-template-layout',array('default' => 'layout-1'));
$wp_customize->add_control('bw-404-template-layout',array(
	'type'		=> 'select',
	'choices'	=> array(
		'layout-1' => __("Layout") . ' 1',
		'layout-2' => __("Layout") . ' 2',
		'layout-1' => __("Layout") . ' 3',
	),
	'setting' => 'bw-404-template-layout',
	'section' => 'bw-404-template'
));

//-> Image
$wp_customize->add_setting('bw-404-template-image');
$wp_customize->add_control('bw-404-template-image',array(
	
));
?>