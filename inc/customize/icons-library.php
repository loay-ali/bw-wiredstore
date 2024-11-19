<?php

require_once __DIR__ .'/fields/list.php';

global $wp_customize;

$wp_customize->add_section('bw-icons-library-section',array(
	'title' => __('Icons Library','bw'),
	'description' => __('Choose Your Favourite Icon Library From a varity of choices','bw'),
	'panel' => 'bw-theme-panel'
));

$bw_icons_list = json_decode(file_get_contents(get_template_directory_uri() .'/assets/docs/icons-libraries.json'));
$bw_icons_list_trimmed = array();

foreach( $bw_icons_list as $item ) {
	array_push($bw_icons_list_trimmed,array('title' => $item->title,'value' => $item->css));
}

$wp_customize->add_setting('bw-icons-library');
$wp_customize->add_control(
	new BW_Customize_List(
		$wp_customize,
		'bw-icon-library',
		array(
			'label' => __('Icons Library','bw'),
			'description' => 'choose the library you like',
			'settings' => 'bw-icons-library',
			'section' => 'bw-icons-library-section',
			'choices' => $bw_icons_list_trimmed
		)
	)
		);
?>