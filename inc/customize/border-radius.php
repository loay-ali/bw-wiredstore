<?php

global $wp_customize;

//Section
$wp_customize->add_section('bw_border_radius',array(
	'title' => __("Border Radius",'bw'),
	'description' => __("Manage Rounded Angels For Elements In The Website",'bw'),
	'panel' => 'bw-theme-panel'
));

//[edit]
foreach( array('top','right','bottom','left') as $direction ) {

	$wp_customize->add_setting('bw_border_radius_'. $direction,array('default' => 0));
	$wp_customize->add_control('bw_border_radius_'. $direction,array(

		'type' => 'number',

		'label' => ucfirst($direction),

		'min' => '0',
		'max' => '999999',

		'section' => 'bw_border_radius'
	));
}

?>