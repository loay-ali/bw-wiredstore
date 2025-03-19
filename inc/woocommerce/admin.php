<?php

class BW_Woocommerce_Admin {

    public function __construct() {

        //(Q & A) Settings Field
        add_action('admin_init',array($this,'register_qa_fields'));

        //(Q & A) Product Page's Tab
        add_action('admin_init',array($this,'qa_product_tab'));

        //Save Product Data -> Question and Answer Exludision
        add_action('save_post_product',array($this,'save_product_qa'));

        //Scripts
        add_action( 'admin_enqueue_scripts', array($this,'scripts') );
    }

    public function scripts() {

        switch( get_current_screen()->id ) {
            case 'options-writing':
                wp_enqueue_script( 'bw-qa-script', get_template_directory_uri() .'/assets/admin/qa.js', array('jquery'), false, true );
            break;
        }

/*         var_dump(get_current_screen(  )->id);
        die; */
    }

    public function sanitize_qa_list($arr) {
     
        $data = get_option('bw_content_qa',array());
        $new = array();

        $timestamp = time();

        for( $count = 0;$count < count($arr['title']);$count++ ) {

            if( empty($arr['title'][$count]) || empty($arr['content'][$count]) )
                continue;

            //Add The Question If Not Exists.
            if( empty($arr['code'][$count]) || !array_key_exists($arr['code'][$count],$data) ) {

                $new[hash('adler32', $count . $timestamp)] = array(
                    'title' => htmlspecialchars($arr['title'][$count]),
                    'content' => htmlspecialchars($arr['content'][$count])
                );
            }else { //Update The Data.

                $new[$arr['code'][$count]]['title'] = htmlspecialchars($arr['title'][$count]);
                $new[$arr['code'][$count]]['content'] = htmlspecialchars($arr['content'][$count]);
            }
        }

        return (array)$new;
    }

    public function register_qa_fields() {

        //Grouped Section
        add_settings_section( 'bw_admin_qa', __("FAQ Settings",'bw'), function() {
            ?>
            <p class = 'description'>...</p>
            <?php
        }, 'writing' );

        //Settings
        register_setting( 'writing', 'bw_enable_qa' ,array('type' => 'boolean','default' => false));
        register_setting( 'writing', 'bw_content_qa', array('type' => 'array','sanitize_callback' => array($this,'sanitize_qa_list')));

        //Enable/Disable
        add_settings_field( 'bw_enable_qa', __("Allow"), function() {
    
            ?>
            <input
                type = "checkbox"
                name = "bw_enable_qa"
                id   = "bw_enable_qa"
                <?php checked((bool)get_option('bw_enable_qa',false));?> />
            <?php
        }, 'writing', 'bw_admin_qa' );

        //Questions List
        add_settings_field( 'bw_list_qa' , __("Content"), function() {
            get_template_part( '/templates/admin/qa', '' ,array('vals' => get_option('bw_content_qa',array())) );}, 'writing', 'bw_admin_qa' );
    }

    public function save_product_qa($post_id) {

        if( !empty($_POST['bw_excluded_qa']) && is_array($_POST['bw_excluded_qa']) )
            update_post_meta( $post_id, 'bw_excluded_qa', array_map('htmlspecialchars',$_POST['bw_excluded_qa']));
        else
            update_post_meta( $post_id, 'bw_excluded_qa', array());
    }

    public function qa_product_tab($post_id) {

        add_meta_box( 'bw_product_qa', __("FAQ"), function($post) {

            get_template_part('/templates/admin/product-qa','',array(
                'vals' => get_option('bw_content_qa',array()),
                'products_exclude' => (array)get_post_meta( $post->ID, 'bw_excluded_qa', true )
            ));
        }, 'product' );
    }
}

return new BW_Woocommerce_Admin;
?>