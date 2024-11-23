<?php

class BW_Setup_Wizard {
    public $settings;

    function __construct() {
        $this->settings = array(

            'template' => array(
    
                'title' => __("Template"),
                'data' => array(
    
                    'template' => array(
                        
                        'type' => 'radio-imgs',
                        'values' => array(
    
                            'clothes' => array(
                                'image' => '',
                                'title' => __("Clothes Shop",'bw')
                            ),
    
                            'home-appliance' => array(
                                'image' => '',
                                'title' => __("Home appliances",'bw')
                            ),
    
                            'electronics' => array(
                                'image' => '',
                                'title' => __("Electronics",'bw')
                            )
                        )
                    )
                )
            )
        );
    }

    static function check() {
        return (isset($_GET['bw-setup-wizard'])
        &&  !empty($_GET['bw-setup-wizard'])
        &&  is_string($_GET['bw-setup-wizard'])
        &&  strlen($_GET['bw-setup-wizard']) <= 30 );
    }

    function entry_point() {


        if( self::check() && array_key_exists($_GET['bw-setup-wizard'],$this->settings) ) {
            

        }
    }
}
?>