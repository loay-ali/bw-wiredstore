<?php

require_once __DIR__ .'/fields/list.php';

global $wp_customize;

//Panel.
$wp_customize->add_panel("bw-google-fonts-panel",array(
	'title' 		=> __("Fonts",'bw'),
	'description'	=> __("Modify Your Fonts Using Google Fonts",'bw')
));

/** Sizes **/
$wp_customize->add_section(
	'bw-font-sizes',
	array(
		'title'			=> __("Sizes"),
		'description'	=> __("Manage Font Sizes",'bw'),
		'panel'			=> 'bw-google-fonts-panel'
	)
);

//Headings
foreach( array(1,2,3,4,5,6) as $heading ) {

	$wp_customize->add_setting('bw_font_size_heading_'. $heading);
	$wp_customize->add_control('bw_font_size_heading_'. $heading,array(

		'type' => 'number',
		
		'label' => __("Heading ". $heading ." (H". $heading .") Size",'bw'),

		'section' => 'bw-font-sizes'
	));
}

//Rest Of Elements
$wp_customize->add_setting('bw_font_size_default');
$wp_customize->add_control('bw_font_size_default',array(

	'type' => 'number',
	
	'label' => __("Normal Font Size",'bw'),

	'section' => 'bw-font-sizes'
));

/** List To Choose From ( Direct ) **/
$wp_customize->add_section(
	'bw-google-fonts-list',
	array(
		'title' 		=> 'List of Fonts',
		'description'	=> 'Choose From Fonts In Google Fonts',
		'panel' 		=> 'bw-google-fonts-panel'
	)
);

$bw_fonts_list = json_decode(file_get_contents(get_template_directory_uri() .'/assets/docs/google-fonts.json'));
$bw_fonts_trimmed_list = array();

foreach( $bw_fonts_list as $item ) {
	array_push($bw_fonts_trimmed_list,array('title' => $item->family,'value' => $item->family));
}

$wp_customize->add_setting('bw-google-fonts-choice');
$wp_customize->add_control(
	new BW_Customize_List(
		$wp_customize,
		'bw-google-fonts-choice',
		array(
			'label'			=> 'Choose Font Library',
			'description'	=> '',
			'settings'		=> 'bw-google-fonts-choice',
			'section'		=> 'bw-google-fonts-list',
			'choices'		=> $bw_fonts_trimmed_list
		)
	)
);

$wp_customize->add_control(
	'bw-clear-google-fonts-choice',
	array(
		'type'		=> 'button',
		'settings'	=> array(),
		'section'	=> 'bw-google-fonts-list',
		'input_attrs' => array(
			'value' => 'Clear',
			'class' => 'button',
			'onclick' => "document.getElementById('bw-list-content').querySelector(\"input[type='radio']:checked\").checked = false;"
		)
	)
		);

/** Custom Fields Section **/
$wp_customize->add_section("bw-google-fonts-custom-fields",array(

	'title'			=> __('Custom Fields','bw'),
	'description'	=> __('Use Custom Fields To Specifiy Your Desired Font','bw'),
	'panel'			=> 'bw-google-fonts-panel'
));

//Font Name.
$wp_customize->add_setting('bw-font-name',array('sanitize_callback' => 'esc_html'));
$wp_customize->add_control('bw-font-name',array(

	'label'		=> __("Font Name *",'bw'),
	'type'		=> 'text',
	'section'	=> 'bw-google-fonts-custom-fields'));

//Subset.
$wp_customize->add_setting('bw-font-subset',array('sanitize_callback' => 'esc_html'));
$wp_customize->add_control('bw-font-subset',array(
	
	'label'		=> __('Subset','bw'),
	'type'		=> 'text',
	'section'	=> 'bw-google-fonts-custom-fields'));

//Font Styles.
//Bold.
$wp_customize->add_setting('bw-font-is-bold',array('sanitize_callback' => 'rest_sanitize_boolean'));
$wp_customize->add_control('bw-font-is-bold',array(
	
	'label'		=> __("Bold ?",'bw'),
	'type'		=> 'checkbox',
	'section'	=> 'bw-google-fonts-custom-fields'));

//Italic.
$wp_customize->add_setting('bw-font-is-italic',array('sanitize_callback' => 'rest_sanitize_boolean'));
$wp_customize->add_control('bw-font-is-italic',array(

	'label'		=> __("Italic ?",'bw'),
	'type'		=> 'checkbox',
	'section'	=> 'bw-google-fonts-custom-fields'));

/* URL Section */
$wp_customize->add_section('bw-google-fonts-url',array(

	'title'			=> __("URL",'bw'),
	'description'	=> __("Use Direct Font Link",'bw'),
	'panel'			=> 'bw-google-fonts-panel'
));

//Use URL ?.
$wp_customize->add_setting('bw-fonts-use-url',array('default'	=> false,'sanitize_callback' => 'rest_sanitize_boolean'));
$wp_customize->add_control('bw-fonts-use-url',array(
	
	'label'		=> __("Use URL ?",'bw'),
	'section'	=> 'bw-google-fonts-url',
	'type'		=> 'checkbox'
));

//URL
$wp_customize->add_setting('bw-font-url',array('sanitize_callback' => 'esc_url'));
$wp_customize->add_control('bw-font-url',array(

	'label'		=> __("URL",'bw'),
	'type'		=> 'url',
	'section'	=> 'bw-google-fonts-url'));

//Languages ( Delay ) **********.

?>