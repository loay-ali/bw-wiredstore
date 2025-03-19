<?php

class BW_Mail {

    function __construct() {

        //Define Custom WooCommerce E-Mail Template Header.
        /* _Header_ */
        add_action('woocommerce_email_header',array($this,'header'),11,2);

        /* _Footer_ */
        add_action('woocommerce_email_footer',array($this,'footer'),11);

        //Remove App Promotion.
        //remove_action('woocommerce_email_footer',array($this,'remove_email_ad'));
    }

    function remove_email_ad () {

        $object = WC()->mailer();
        remove_action( 'woocommerce_email_footer', array( $object, 'mobile_messaging' ), 9 );
    }

    function header($email_heading,$email) {

        remove_all_actions('woocommerce_email_header',10);

        $header = file_get_contents(__DIR__ .'/../templates/emails/header.html');

        $header = str_replace('[title]',esc_html($email_heading),$header);
        $header = str_replace('[site-title]',esc_html(get_bloginfo('name')),$header);

        //Icon.
        if( !empty($email->id) ) {
            switch( $email->id ) {

                case 'customer_reset_password':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/reset-password.png',$header);
                break;

                case 'new_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/new-order.png',$header);
                break;

                case 'review_order':
                    $header = str_replace('[icon]',get_bloginfo( 'url' ) .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/review-email.png',$header);
                break;

                case 'cancelled_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-cancelled.png',$header);
                break;

                case 'failed_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-failed.png',$header);
                break;

                case 'customer_completed_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-complete.png',$header);
                break;

                case 'customer_on_hold_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-onhold.png',$header);
                break;

                case 'customer_processing_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-processing.png',$header);
                break;

                case 'customer_refunded_order':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-refund.png',$header);
                break;

                case 'customer_new_account':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/new-account.png',$header);
                break;

                case 'customer_invoice':
                case 'customer_note':
                    $header = str_replace('[icon]',get_bloginfo('url') .'/wp-content/plugins/bw-kelvineg-manager/assets/imgs/mail-icons/order-details.png',$header);
                break;
            }
        }

        echo $header;
    }

    function footer($email) {

        remove_all_actions('woocommerce_email_footer',10);

        $footer = file_get_contents(__DIR__ .'/../templates/mails/footer.html');

		$footer = str_replace('[phone-number]','',$footer);

		echo $footer;
    }

    static function prepare_email($template,$data) {

        if( ! file_exists(__DIR__ .'/../templates/mails/'. $template .'.html') )
            return false;

        $header = file_get_contents(__DIR__ .'/../templates/mails/header.html');
        $footer = file_get_contents(__DIR__ .'/../templates/mails/footer.html');

        $template = file_get_contents(__DIR__ .'/../templates/mails/'. $template .'.html');

        $template = str_replace('[header]',$header,$template);
        $template = str_replace('[footer]',$footer,$template);

        foreach( $data as $key => $value ) {

            $header = str_replace($key,$value,$header);
            $footer = str_replace($key,$value,$footer);

            $template = str_replace($key,$value,$template);
        }

        return $template;
    }
}

return new BW_Mail;
?>