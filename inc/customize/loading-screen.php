<?php

require_once __DIR__ .'/fields/built-in-color.php';
require_once __DIR__ .'/fields/image-list.php';

global $wp_customize;

$wp_customize->add_section('bw-loading-screen-section',array(
    'title' => __("Loading Screen",'bw'),
    'description' => __("Manage Your Loading Splash Screen",'bw')
));

//Enable / Disable
$wp_customize->add_setting('bw-loading-screen-enable',array(

	'default' 			=> true,
	'sanitize_callback'	=> 'rest_sanitize_boolean'
));
$wp_customize->add_control('bw-loading-screen-enable',array(

	'label'		=> __("Enable Loading Screen",'bw'),
	'section'	=> 'bw-loading-screen-section',
	'type'		=> 'checkbox',
    'setting'   => 'bw-loading-screen-enable'
));

//Background Color
$wp_customize->add_setting('bw-loading-screen-bg',array('default' => 'white'));
$wp_customize->add_control(
    new BW_Color_Choice(
        $wp_customize,
        'bw-loading-screen-bg',
        array(
            'section'       => 'bw-loading-screen-section',
            
            'label'         => __("Background Color"),
            'description'   => ''
        )
    )
);

//Foreground Color
$wp_customize->add_setting('bw-loading-screen-fg',array('default' => 'black'));
$wp_customize->add_control(
    new BW_Color_Choice(
        $wp_customize,
        'bw-loading-screen-fg',
        array(
            'section'       => 'bw-loading-screen-section',
            
            'label'         => __("Foreground Color",'bw'),
            'description'   => ''
        )
    )
);

$bw_templates_list = array();
foreach( array('3-dots','spinning-dots','lingar-bar') as $template ) {
    $bw_templates_list[$template] = get_template_directory_uri() .'/assets/imgs/loading-templates/'. $template .'.jpg';
}

//Template ( Design )
$wp_customize->add_setting('bw-loading-screen-template',array('default' => ''));
$wp_customize->add_control(
    new BW_Customize_Image_List(
        $wp_customize,
        'bw-loading-screen-template',
        array(
            'section' => 'bw-loading-screen-section',
            'label' => __("Template"),
            'description' => '',
            'setting' => 'bw-loading-screen-template',
            'choices' => $bw_templates_list,
            'grid' => 4
        )
    )
);

?>