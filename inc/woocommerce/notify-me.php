<?php

class BW_WS_Back_Orders {

    function __construct() {

        //Frontend ( Product Page )
        add_action('woocommerce_product_meta_start',array($this,'template'));

        //Frontend ( Dashboard )
        add_action('init',function() { add_rewrite_endpoint( 'backorders', EP_PERMALINK | EP_PAGES );});
        add_filter('woocommerce_account_menu_items',array($this,'dashboard_menu_item'));
        add_action('woocommerce_account_backorders_endpoint',array($this,'dashboard_content'));

        //Ajax.
        add_action('wp_ajax_bw_notify_me',array($this,'ajax_add')); //Add On Privilged.
        add_action('wp_ajax_nopriv_bw_notify_me',array($this,'ajax_add_cookie')); //Add With No Privilged.
        add_action('wp_ajax_bw_notify_me_remove',array($this,'ajax_remove')); //Remove On User Dashboard.
        add_action('wp_ajax_nopriv_bw_notify_me_remove','__return_false'); //Don't Remove On No Privilge.

        //On Product Status Change.
        add_action('woocommerce_product_set_stock',array($this,'send_mail'));

        //Admin Menu Notification.
        add_action('admin_bar_menu',array($this,'admin_topbar'),1000);

        //Switch BackOrder By Phone Status.
        add_action('admin_init',array($this,'switch_status'));

        //Resend Notification.
        add_action('admin_init',array($this,'resend_notify'));
    
        //Setup DB Table.
        add_action('switch_theme',array($this,'create_db_table'));
    }

    function create_db_table() {
        global $wpdb;

        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}bw_notify_me (
            id BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            customer_id BIGINT(20) NOT NULL,
            customer_type VARCHAR(10) NOT NULL DEFAULT 'email',
            customer_data VARCHAR(100) NOT NULL,
            status TINYINT(1) NOT NULL,
            release_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            product_id BIGINT(20) NOT NULL,
            send_date TIMESTAMP
        )");
    }

    function resend_notify() {

        if( !empty($_GET['page'])
        &&  is_string($_GET['page'])
        &&  $_GET['page'] == 'kelvin-backorders'
        &&  !empty($_GET['operation'])
        &&  is_string($_GET['operation'])
        &&  $_GET['operation'] == 'resend'
        &&  !empty($_GET['nonce'])
        &&  is_string($_GET['nonce'])
        &&  wp_verify_nonce(htmlspecialchars($_GET['nonce']),'bw-resend-notify-nonce') != false ) {

            self::bw_resend_notify();
        }
    }

    static function bulk_switch($requests) {

        global $wpdb;

        $wpdb->query("UPDATE {$wpdb->prefix}bw_notify_me SET status = 2,send_date = (NOW()) WHERE id IN(". implode(',',$requests) .")");
    }

    function switch_status() {

        if( !empty($_GET['bw-switch-backorder']) && is_string($_GET['bw-switch-backorder']) ) {

            $this->update_notify_me(absint($_GET['bw-switch-backorder']));
            
            $filters = [];
            if( !empty($_GET['s']) )
                array_push($filters,'s='. htmlspecialchars($_GET['s']));

            if( !empty($_GET['bw-status-only']) )
                array_push($filters,'bw-status-only='. htmlspecialchars($_GET['bw-status-only']));

            if( !empty($_GET['bw-product-stock-only']) )
                array_push($filters,'bw-product-stock-only='. htmlspecialchars($_GET['bw-product-stock-only']));

            if( !empty($_GET['bw-customer-contact-only']) )
                array_push($filters,'bw-customer-contact-only='. htmlspecialchars($_GET['bw-customer-contact-only']));

            if( !empty($_GET['bw-request-date']) )
                array_push($filters,'bw-request-date='. htmlspecialchars($_GET['bw-request-date']));
            ?>
            
            <script>
            window.location = '<?php echo get_admin_url() .'admin.php?page=kelvin-backorders'. (count($filters) == 0 ? '':'&'. implode('&',$filters));?>';
            </script>
            <?php
        }
    }

    function admin_topbar($admin_bar) {

        $admin_bar->add_node(array(

            'id'        => 'bw_backorders_count',
            'title'     => 'طلبات التنبيه للهاتف <span style = "background:#dc3545;color;#FFF;border-radius:50px;padding:0 5px;">'. self::get_phone_backorders() .'</span>',
            'href'      => get_admin_url() .'admin.php?page=bw-notify-me&bw-status-only=1&bw-product-stock-only=instock&bw-customer-contact-only=phone',
            'priority'  => 1000,
        ));
    }

    static function get_phone_backorders() {

        global $wpdb;

        $res = $wpdb->get_col(sprintf(
            "SELECT COUNT(bo.id) FROM {$wpdb->prefix}bw_notify_me bo LEFT JOIN {$wpdb->postmeta} pm ON(bo.product_id=pm.post_id AND pm.meta_key = '_stock') WHERE pm.meta_value > 0 AND bo.status = 1 AND bo.customer_type = 'phone' AND bo.customer_data != ''"
        ));

        return empty($res[0]) ? 0:$res[0];
    }

    function send_mail($product) {

        if( $product->get_stock_quantity() == 0 )
            return;

        $message = BW_Mail::prepare_email('backorders-available',array(

            '[title]'           => 'المنتج الذى تريده متوفر الأن',
            '[icon]'            => '',
            '[product-image]'   => wp_get_attachment_image_url( $product->get_image_id(), 'medium' ),
            '[product-name]'    => $product->get_title(),
            '[product-price]'   => $product->get_price() .'<sub>'. get_woocommerce_currency_symbol() .'</sub>',
            '[buy-btn-link]'    => $product->get_permalink()
        ));

        $clients = self::get_product_backorders($product->get_id());

        foreach( $clients as $client ) {

            wp_mail( $client, 'المنتج الذى تريد متوفر الأن', $message,array(

                'Content-Type: text/html; charset=UTF-8'
            ));
        
            $backorder_id = $this->get_backorder_id($client,$product->get_id());

            $this->update_backorder($backorder_id[0],2);
        }

        //$this->remove_backorders($product->get_id());
    }

    private function get_backorder_id($user_email,$product_id) {

        global $wpdb;

        return $wpdb->get_col(sprintf(
            "SELECT id FROM {$wpdb->prefix}bw_notify_me WHERE customer_type = 'email' AND customer_data = '%s' AND product_id = %d",
            $user_email,
            $product_id
        ));
    }

    private function update_backorder($id,$status = 2) {

        global $wpdb;

        $wpdb->update($wpdb->prefix .'bw_notify_me',array('status' => absint($status),'send_date' => date("Y-m-d H:i:s")),array('id' => $id));
    }

    function dashboard_content() {
    
        $bw_backorders = self::get_user_backorders();

        if( ! is_null($bw_backorders) && $bw_backorders != false ):?> 
        <table class = 'shop_table shop_table_responsive cart woocommerce-cart-form__contents'>
            <?php foreach( $bw_backorders as $backorder ):?>
                <tr>
                    <td class = 'text-right'>
                        <div style = 'width:100%;display:block;'>
                            <?php echo $backorder->product_name;?>
                        </div>
                        <span>
                            <?php echo $backorder->status == 1 ? '<span style = "color:#dc3545;">غير متوفر فى المخزون</span>':'<span style = "color:#28a745;">متوفر الأن</span>!';?>
                        </span>
                    </td>
                    <td>
                        <button type = "button" class = 'mf-remove bw-notify-my-btn-remove' bw-item = '<?php echo $backorder->product_id;?>' style = 'background:#FFF;color:#333;border-radius:50px;border:none;'>
                            <i class="icon-cross2"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    <?php else:?>
        <div class = 'text-center' style = 'font-size:30px;'>
            <h3>
                <?php _e("No Notifications Right Now...",'bw');?>
            </h3>
            <i class="fa fa-bell"></i>
        </div>
    <?php endif;}

    function dashboard_menu_item($items) {

        $items['backorders'] = 'تنبيهات التوافر';

        return $items;
    }

    function remove_backorders($product_id) {

        global $wpdb;

        if( ! current_user_can('edit_users') )
            return false;

        $wpdb->delete(
            $wpdb->prefix .'bw_notify_me',
            array(

                'product_id' => $product_id
            ),
            array(
                '%d'
            )
        );

        return true;
    }

    static function bw_resend_notify() {

        global $wpdb;

        $unsent = $wpdb->get_results("SELECT nm.id as request_id,p.ID as product_id,nm.customer_data as email FROM {$wpdb->prefix}bw_notify_me nm LEFT JOIN {$wpdb->posts} p ON(p.ID=nm.product_id) LEFT JOIN {$wpdb->postmeta} pm ON(pm.post_id=p.ID AND pm.meta_key = '_stock_status' AND pm.meta_value = 'instock') WHERE nm.status = 1 AND nm.customer_type = 'email' AND nm.customer_data != ''");
    
        foreach( $unsent as $data ) {

            $product = wc_get_product($data->product_id);

            //if( $product->get_stock_quantity() == 0 )
            //    return;

            $message = BW_Mail::prepare_email('backorders-available',array(

                '[title]'           => 'المنتج الذى تريده متوفر الأن !',
                '[icon]'            => '',
                '[product-image]'   => wp_get_attachment_image_url( $product->get_image_id(), 'medium' ),
                '[product-name]'    => $product->get_title(),
                '[product-price]'   => $product->get_price() .'<sub>'. get_woocommerce_currency_symbol() .'</sub>',
                '[buy-btn-link]'    => $product->get_permalink()
            ));

            wp_mail($data->email , 'المنتج الذى تريد متوفر الأن', $message,array(

                'Content-Type: text/html; charset=UTF-8'
            ));

            $wpdb->update($wpdb->prefix .'bw_notify_me',array('status' => 2,'send_date' => date("Y-m-d H:i:s")),array('id' => $data->request_id));    
        }

        wp_redirect( get_admin_url() .'admin.php?page=bw-notify-me-data' );
    }

    static function get_product_backorders($product_id) {

        global $wpdb;

        return $wpdb->get_col(sprintf(
            "SELECT customer_data FROM {$wpdb->prefix}bw_notify_me WHERE product_id = %d AND customer_type = 'email' AND status != 2 ORDER BY release_date ASC",
            $product_id
        ));
    }

    static function get_user_backorders() {

        global $wpdb;

        $user_id = get_current_user_id();

        return $wpdb->get_results(sprintf(
            "SELECT nm.*,pr.post_title as product_name FROM {$wpdb->prefix}bw_notify_me nm LEFT JOIN {$wpdb->posts} pr ON(nm.product_id=pr.ID AND pr.post_type = 'product') WHERE nm.customer_id = %d",
            $user_id
        ));
    }

    static function is_in_backorder($email,$phone,$product_id) {

        global $wpdb;

        if( $email == '' && $phone == '' && is_user_logged_in() == false && is_int($product_id) ) {

            $bw_data = empty($_COOKIE['bw_notify_me']) ? array():array_map('absint',json_decode($_COOKIE['bw_notify_me']));

            if( in_array($product_id,$bw_data) )
                return true;

            return false;
        }

        if( (!is_email($email) && preg_match('/01\d{9}/',$phone) == 0) || ! is_int($product_id) )
            return false;

        $user_id = wp_get_current_user()->ID;

        $res = $wpdb->get_row(sprintf(
            "SELECT COUNT(id) FROM {$wpdb->prefix}bw_notify_me WHERE product_id = %d AND (customer_data = '%s' OR customer_id = %d) AND status = 0",
            $product_id,
            empty($email) ? $phone:$email,
            $user_id
        ),ARRAY_N);

        if( is_countable($res) &&  count($res) > 0 && (is_int($res[0]) || is_string($res[0])) && $res[0] > 0 )
            return true;
        
        return false;
    }

    static function remove_notification($user_id,$product_id) {

        global $wpdb;

        if( !is_int($user_id) || !is_int($product_id) )
            return false;

        $wpdb->delete(
            $wpdb->prefix .'bw_notify_me',
            array('customer_id' => $user_id,'product_id' => $product_id)
        );

        return true;
    }

    static function add_notification($user_id,$email_or_phone,$product_id,$type = 'email') {

        global $wpdb;

        if( ($type == 'email' && !is_email($email_or_phone)) || ($type == 'phone' && preg_match('/01\d{9}/',$email_or_phone) == 0) || ! is_int($user_id) || ! is_int($product_id) )
            return false;

		if( count($wpdb->get_col(sprintf("SELECT * FROM {$wpdb->prefix}bw_notify_me WHERE customer_data = '%s' AND product_id = %d",$email,$product_id))) != 0 )
			return false;

        $insert = array(
            'customer_id'   => $user_id,
            'product_id'    => $product_id
        );

        $insert['customer_data'] = $email_or_phone;
        $insert['customer_type'] = $type;

        $wpdb->insert(
            $wpdb->prefix .'bw_notify_me',
            $insert
        );

        return true;
    }

    function ajax_add_cookie() {

        if( empty($_POST['nonce'])
        ||  wp_verify_nonce( $_POST['nonce'], 'bw_notify_me' ) == false
        ||  empty($_POST['email_or_phone'])
        ||  !is_string($_POST['email_or_phone'])
        ||  empty($_POST['type'])
        ||  !is_string($_POST['type'])
        ||  !in_array($_POST['type'],array('email','phone'))
        ||  ($_POST['type'] == 'email' && !is_email($_POST['email_or_phone']))
        ||  ($_POST['type'] == 'phone' && preg_match('/01\d{9}/',$_POST['email_or_phone']) == 0)
        ||  empty($_POST['product'])
        ||  !is_string($_POST['product']) )
            die;

        $current_products = empty($_COOKIE['bw_notify_me']) ? array():array_map('absint',json_decode($_COOKIE['bw_notify_me']));

        $email_or_phone = $_POST['type'] == 'email' ? sanitize_email($_POST['email_or_phone']):htmlspecialchars($_POST['email_or_phone']);
        $product = absint($_POST['product']);

        array_push( $current_products,$product );

        setcookie( 'bw_notify_me',json_encode($current_products),time() + (( 60 * 60 * 24 ) * 365.25), '/' );

        self::add_notification(-1,$email_or_phone,$product,$_POST['type']);

        echo 1;

        die;
    }

    function ajax_add() {

        if( empty($_POST['nonce'])
        ||  wp_verify_nonce( $_POST['nonce'], 'bw_notify_me' ) == false
        ||  empty($_POST['type'])
        ||  !is_string($_POST['type'])
        ||  !in_array($_POST['type'],array('email','phone'))
        ||  empty($_POST['email_or_phone'])
        ||  !is_string($_POST['email_or_phone'])
        ||  ($_POST['type'] == 'email' && !is_email($_POST['email_or_phone']))
        ||  ($_POST['type'] == 'phone' && preg_match('/01\d{9}/',$_POST['email_or_phone']) == 0)
        ||  empty($_POST['product'])
        ||  !is_string($_POST['product']) )
            die;

        $user = get_current_user_id();
        $product = absint($_POST['product']);
        $email_or_phone = $_POST['type'] == 'email' ? sanitize_email($_POST['email_or_phone']):htmlspecialchars($_POST['email_or_phone']);

        self::add_notification($user,$email_or_phone,$product,$_POST['type']);

        echo 1;

        die;
    }

    function ajax_remove() {

        if( empty($_POST['nonce'])
        ||  wp_verify_nonce( $_POST['nonce'], 'bw_remove_backorder_request' ) == false
        ||  empty($_POST['product'])
        ||  !is_string($_POST['product']) )
            die;

        $user_id = get_current_user_id();
        $product_id = absint($_POST['product']);

        self::remove_notification($user_id,$product_id);

        echo 1;

        die;
    }

    function template() {

        global $product;

        if( (! $product->backorders_allowed() || ! $product->is_on_backorder() ) && $product->get_stock_quantity() < 1 ) {

            require_once __DIR__ .'/../../templates/notify-me.php';
        }
    }
}

return new BW_WS_Back_Orders;
?>