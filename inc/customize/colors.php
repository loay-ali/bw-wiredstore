<?php 

global $wp_customize;

/* Site Colors */
$bw_all_colors = array(

	'red'		=> __("Red",'bw'),
	'green'		=> __("Green",'bw'),
	'blue'		=> __("Blue",'bw'),
	'purple'	=> __("Purple",'bw'),
	'pink'		=> __("Pink",'bw'),
	'orange'	=> __("Orange",'bw'),
	'yellow'	=> __("Yellow",'bw'),
	'black'		=> __("Black",'bw'),
	'white'		=> __("White",'bw')
);

$bw_color_types = array(

	'primary'		=> __("Primary",'bw'),
	'secondary' 	=> __("Secondary",'bw'),
	'foreground'	=> __("Foreground",'bw'),
);

$bw_color_varies = array(

	'danger'		=> __("Danger",'bw'),
	'info'			=> __("Info",'bw'),
	'success'		=> __("Success",'bw')
);

//Colors
foreach( $bw_all_colors as $color_code => $color_title ) {

 	$wp_customize->add_setting('bw_color_'. $color_code);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bw_color_'. $color_code,
			array(
				'label'			=> $color_title,
				'descritpion'	=> '',
				'section'		=> 'colors',
				'setting'		=> 'bw_color_'. $color_code
			)
		)
	);
}

//Choose Types
foreach( $bw_color_types as $type_value => $type_title ) {

	$wp_customize->add_setting('bw_'. $type_value .'_color');
	$wp_customize->add_control('bw_'. $type_value .'_color',array(
		'type'		=> 'select',
		'label'		=> $type_title,
		'choices'	=> $bw_all_colors,
		'section'	=> 'colors'
	));
}

//Choose Vairation
foreach( $bw_color_varies as $var_value => $var_title ) {

	$wp_customize->add_setting('bw_'. $var_value .'_color');
	$wp_customize->add_control('bw_'. $var_value .'_color',array(
		'type'		=> 'select',
		'label'		=> $var_title,
		'choices'	=> $bw_all_colors,
		'section'	=> 'colors'
	));
}

/*
//Primary.
$wp_customize->add_setting("txt-color-1",array('default'=>'#000','sanitize_callback'=>'sanitize_hex_color'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,"txt-color-1",array(
	
	"label"		=>__("Primary Text Color",'bw'),
	'section'	=>"colors")));

//Secondary.
$wp_customize->add_setting("txt-color-2",array('default'=>'#222','sanitize_callback'=>'sanitize_hex_color'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,"txt-color-2",array(
	
	"label"		=>__("Secondary Text Color",'bw'),
	"section"	=>"colors")));

//Links.
$wp_customize->add_setting('link-color',array('default' => '#555','sanitize_callback' => 'sanitize_hex_color'));
$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'link-color',array(
	
	"label" 	=> __("Link Color",'bw'),
	'section' 	=> 'colors')));
	
//Theme Colors.
for( $col = 1;$col <= 5;$col++ ) {
	
	$wp_customize->add_setting('bw-theme-color-'. $col);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'bw-theme-color-'. $col,array(
	
		'label'		=> __("Theme Color ". $col,'bw'),
		'section' 	=> 'colors',
		'setting'	=> 'bw-theme-color-'. $col
	)));
}
*/
?>