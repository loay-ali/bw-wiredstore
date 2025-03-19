<?php

class BW_Setup_Wizard {
    public $settings;
    public static $tables = array(

        'bw_notify_me' => array(
            'id'                => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'customer_id'       => 'BIGINT(20) NOT NULL',
            'cutomer_data'      => 'VARCHAR(255) NOT NULL',
            'customer_type'     => 'ENUM("email","phone") DEFAULT "email"',
            'release_date'      => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
            'product_id'        => 'BIGINT(20) NOT NULL',
            'status'            => 'TINYINT(1) DEFAULT 1',
            'send_date'         => 'TIMESTAMP'
        )
    );

    function __construct() {

        $bw_colors = array();
        foreach( array('red','green','blue','purple','pink','orange','yellow','black','white') as $color ) {
            $bw_colors[$color] = array(
                'type' => 'color',
                'default' => get_theme_mod('bw_color_'. $color),
                'title' => __(ucfirst($color))
            );
        }

        $this->settings = array(

            'template' => array(
    
                'title' => __("Template"),
                'icon' => 'format-gallery',
                'data' => array(
    
                    'template' => array(
                        
                        'title' => __("Choose Initial Template",'bw'),
                        'type' => 'radio-imgs',
                        'required' => true,
                        'values' => array(
    
                            'clothes' => array(
                                'image' => 'ksa.png',
                                'title' => __("Clothes Shop",'bw')
                            ),
    
                            'home-appliance' => array(
                                'image' => 'eg.png',
                                'title' => __("Home appliances",'bw')
                            ),
    
                            'electronics' => array(
                                'image' => 'pl.png',
                                'title' => __("Electronics",'bw')
                            )
                        )
                    )
                )
            ),
            'styling' => array(
                'title' => __("Styling",'bw'),
                'icon' => 'admin-customizer',
                'data' => array_merge(
                    array(
                        //Colors Section
                        'colors' => array(
                            'type' => 'heading',
                            'title' => __("Colors")
                        )
                    ),
                    $bw_colors
                )
            ),
            'supported-plugins' => array(
                'title' => __("Supported Plugins",'bw'),
                'icon' => 'plugins-checked',
                'data' => array(
                    'supported-plugins' => array(
                        'type' => 'checkbox-imgs',
                        'title' => __("Choose the plugins you want",'bw'),
                        'values' => array(
                            'woocommerce' => array(
                                'title' => __("Woocommerce",'wc'),
                                'image' => 'woo.png'
                            ),
                            'jetpack' => array(
                                'title' => __("Jetpack",'jetpack'),
                                'image' => 'jetpack.jpg'
                            )
                        )
                    )
                )
            )
        );
    }

    static function check() {
        return (isset($_GET['stage'])
        &&  !empty($_GET['stage'])
        &&  is_string($_GET['stage'])
        &&  strlen($_GET['stage']) <= 30 );
    }

    public function insert_tables() {

        global $wpdb;

        foreach( self::$tables as $table_slug => $rows ) {

            $wpdb->query(
                sprintf(
                    "CREATE TABLE IF NOT EXISTS %s (%s)",
                    $table_slug,
                    implode(',',$rows)
                )
            );
        }
    }

    public function prev_phase($stage) {

        if( $this->settings[$stage] != reset($this->settings[$stage]) ) {//Not First Phase

            $bw_keys = array_keys($this->settings);
            $next_stage = $bw_keys[array_search($stage,$bw_keys) - 1];

            wp_safe_redirect( get_admin_url() .'admin.php?page=bw-ws-setup-wizard&stage='. $next_stage );
        }
    }

    public function next_phase($stage) {

        if( $this->settings[$stage] == end($this->settings[$stage]) ) {//The Final Phase

            //Table Insertion
            $this->insert_tables();

            wp_safe_redirect( get_admin_url() );
        }else {

            $bw_keys = array_keys($this->settings);
            $next_stage = $bw_keys[array_search($stage,$bw_keys) + 1];

            wp_safe_redirect( get_admin_url() .'admin.php?page=bw-ws-setup-wizard&stage='. $next_stage );
        }
    }

    public function saving($stage) {

        switch( $stage ) {
            
            case 'template':

                if( empty($_POST['template'])
                ||  !is_string($_POST['template'])
                ||  !array_key_exists($_POST['template'],$this->settings['template']['data']['template']['values']) )
                    wp_die('Error Saving, Please Contact Theme\'s Customer Service');

                //Do Something Here

                update_option('bw_debugging_077','done with setup wizard saving method :)');

                $this->next_phase($stage);

            break;
        }
    }

    public function entry_point() {

        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            if( !empty($_POST['bw-submit'])
            &&  is_string($_POST['bw-submit'])
            &&  $_POST['bw-submit'] == 'next'
            &&  !empty($_POST['bw-is-saving'])
            &&  is_string($_POST['bw-is-saving'])
            &&  array_key_exists($_POST['bw-is-saving'],$this->settings) ) {
                $this->saving($_POST['bw-is-saving']);
            }elseif( !empty($_POST['bw-is-saving'])
            &&  is_string($_POST['bw-is-saving'])
            &&  array_key_exists($_POST['bw-is-saving'],$this->settings) ) {

                $this->prev_phase($_POST['bw-is-saving']);
            }
        }

        $_GET['stage'] = self::check() && array_key_exists($_GET['stage'],$this->settings) ? $_GET['stage']:array_keys($this->settings)[0];

        $bw_stages_keys = array_keys($this->settings);
        $bw_current_stage = empty($_GET['stage']) ? $bw_stages_keys[0]:$_GET['stage'];

        //Header
        get_template_part( 'templates/setup_wizard/header', '', array(
            'stages' => $this->settings,
            'stage' => $bw_current_stage
        ) );

        //Content
        get_template_part( 'templates/setup_wizard/content', '', array(
            'data' => $this->settings[$_GET['stage']],
            'stage' => $bw_current_stage
        ) );

        //Footer
        get_template_part( 'templates/setup_wizard/footer', '', array(
            'next' => array_search($bw_current_stage,$bw_stages_keys) == count($bw_stages_keys) - 1 ? __("Finish"):__("Next"),
            'prev' => array_search($bw_current_stage,$bw_stages_keys) == 0 ? false:__("Previous")
        ) );
    }
}
?>