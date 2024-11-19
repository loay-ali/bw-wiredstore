<?php

global $wp_customize;

$wp_customize->add_section('bw-input-style-section',array(
	'panel' => 'bw-theme-panel',
	'title' => __("Inputs"),
	'description' => __("Style Theme's Inputs",'bw')
));

//Use Label
$wp_customize->add_setting('bw-input-use-label',array('default' => true));
$wp_customize->add_control('bw-input-use-label',array(
	'setting' => 'bw-input-use-label',
	'label' => __("Show Label ?",'bw'),
	'type' => 'checkbox',
	'section' => 'bw-input-style-section'
));

//Use Icon
$wp_customize->add_setting('bw-input-use-icon',array('default' => true));
$wp_customize->add_control('bw-input-use-icon',array(
	'setting' => 'bw-input-use-icon',
	'label' => __("Show Icon ?",'bw'),
	'type' => 'checkbox',
	'section' => 'bw-input-style-section'
));
?>