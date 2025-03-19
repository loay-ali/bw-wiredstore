<?php

require_once __DIR__ .'/../../woocommerce/notify-me.php';

class BW_Backorder_Requests_Form_Table extends WP_List_Table {

    public $s,$order,$order_by,$p,$dedicated_inputs;

    function __construct() {

        parent::__construct(array(

            'singular'  => 'طلب',
            'plural'    => 'requests',
            'ajax'      => false
        ));
    }

    function get_columns() {

        return array(

            'id'            => 'رقم الطلب',
            'customer'      => 'معلومات العميل',
			'type'			=> 'نوع المراسلة',
            'product'       => 'المنتج',
            'status'        => 'الحالة',
            'sent'          => 'هل تم الأرسال',
            'release_date'  => 'تاريخ الطلب',
			'switch'		=> ''
        );
    }

    function get_sortables() {

        return array(

            'customer'      => array('bo.customer_email,bo.customer_phone',false),
			'type'			=> array('bo.type',false),
            'product'       => array('pr.post_title',false),
            'status'        => array('pm.meta_value',false),
            'release_date'  => array('bo.release_date',true),
        );
    }

    function get_bulk_actions() {

        return array(
            'send'  => 'تم الأرسال'
        );
    }

    function column_cb($item) {

        return ($item->customer_phone != '' && $item->status == 1) ? "<input type = 'checkbox' name = 'bw-request[". $item->id ."]' />":'';
    }

    function process_bulk_action() {

        if( !empty($_POST['_wpnonce'])
        &&  wp_verify_nonce( $_POST['_wpnonce'],'bulk-requests' ) != false
        &&  !empty($_POST['bw-request'])
        &&  is_array($_POST['bw-request']) ) {
    
            $requests = array_map('absint',array_keys($_POST['bw-request']));

            BW_KEG_Back_Orders::bulk_switch($requests);

            echo '<div class="notice notice-success is-dismissible"><p>تم التعديل</p></div>';
        }
    }

    function column_default($item,$col_name) {

        switch( $col_name ){

            case 'id':
                return $item->id;
            break; 

			case 'type':
				
				$tmpData = [0 => 'عبر الإيميل',1 => 'عبر الهاتف',2 => 'عبر الواتس اب'];
				
				return (array_key_exists($item->type,$tmpData) ? $tmpData[$item->type]:'غير محدد');
			break;

            case 'customer':

                return $item->customer_email == '' ? $item->customer_phone:$item->customer_email;
            break;

            case 'sent':

                return (isset($item->status) && $item->status > 1) ? 'تم الأرسال':'لم يتم الأرسال بعد';
            break;

            case 'product':

                return $item->post_title;
            break;

            case 'status':

                return $item->stock == 'instock' ? 'متوفر':'غير متوفر';
            break;

            case 'release_date':
                return Date("<b>Y-m-d</b> h:i <\i>A</\i>",strtotime($item->release_date));
            break;

            case 'switch':
                return ($item->customer_phone != '' && $item->status == 1 && $item->type == 1) ? '<a class = "button" href = "?bw-customer-contact-only='. (empty($_GET['bw-customer-contact-only']) ? '':htmlspecialchars($_GET['bw-customer-contact-only'])) .'&s='. (empty($_GET['s']) ? '':htmlspecialchars($_GET['s'])) .'&bw-status-only='. (empty($_GET['bw-status-only']) ? '':htmlspecialchars($_GET['bw-status-only'])) .'&bw-product-stock-only='. (empty($_GET['bw-product-stock-only']) ? '':htmlspecialchars($_GET['bw-product-stock-only'])) .'&bw-request-date='. (empty($_GET['bw-request-date']) ? '':htmlspecialchars($_GET['bw-request-date'])) .'&bw-switch-backorder='. $item->id .'">تم الأرسال</a>':'';
            break;
        }
    }

    function get_items() {

        global $wpdb;

        $this->p = empty($_GET['paged']) ? 1:absint($_GET['paged']);//Define Current Page.

        $this->dedicated_inputs = array(

            'status'    => empty($_GET['bw-status-only']) || !in_array($_GET['bw-status-only'],array('1','2')) ? '':$_GET['bw-status-only'],
			'stock'     => empty($_GET['bw-product-stock-only']) || !in_array($_GET['bw-product-stock-only'],array('instock','outofstock')) ? '':$_GET['bw-product-stock-only'],
            'contact'   => empty($_GET['bw-customer-contact-only']) || !in_array($_GET['bw-customer-contact-only'],array('email','phone','whatsapp')) ? '':$_GET['bw-customer-contact-only'],
            'date'      => empty($_GET['bw-request-date']) || is_date($_GET['bw-request-date']) ? '':$_GET['bw-request-date']
        );

        $sortables = $this->get_sortables();

        $this->_column_headers = array(

            $this->get_columns(),
            array(),
            $sortables,
            'id'
        );

        $this->process_bulk_action();

        //Search.
        $phone_only = !empty($_GET['order']) && is_string($_GET['order']) && $_GET['order'] == 'phone-only' ? "bo.customer_phone != '' AND":'';

        $this->s = empty($_GET['s']) ? '':htmlspecialchars($_GET['s']);
        $search_query = $this->s != '' ? sprintf('(bo.customer_phone LIKE "%1$s" OR bo.customer_email LIKE "%1$s")','%'. $this->s .'%'):' 1 = 1 ';

        $dedicated_query = !empty($this->dedicated_inputs['status']) ? sprintf(" AND (bo.status = %d) ",$this->dedicated_inputs['status']):'AND (1 = 1)';
        $dedicated_query .= !empty($this->dedicated_inputs['stock']) ? sprintf(" AND (pm.meta_value = '%s') ",$this->dedicated_inputs['stock']):'AND (1 = 1)';
        $dedicated_query .= !empty($this->dedicated_inputs['contact']) ? ($this->dedicated_inputs['contact'] == 'email' ? " AND type = 0":($this->dedicated_inputs['contact'] == 'phone' ? " AND type = 1":" AND type = 2")):'AND (1 = 1)';
        $dedicated_query .= !empty($this->dedicated_inputs['date']) ? sprintf(" AND (bo.release_date LIKE '%s')",'%'. $this->dedicated_inputs['date'] .'%'):' AND (1 = 1)';

        $this->order_by = empty($_GET['orderby']) || !in_array($_GET['orderby'],array_map(function($ele){ return $ele[0];},$sortables)) ? 'release_date':$_GET['orderby'];
        $this->order = (empty($_GET['order']) || !in_array($_GET['order'],array('asc','desc'))) ? 'desc':$_GET['order'];

        $order_query = "ORDER BY {$this->order_by} {$this->order}";

        $query = sprintf(
            "SELECT bo.*,pr.post_title,pm.meta_value as stock FROM
                {$wpdb->prefix}bw_backorders bo
                LEFT JOIN {$wpdb->posts} pr ON(pr.ID=bo.product_id)
                LEFT JOIN {$wpdb->postmeta} pm ON(pm.post_id = pr.ID AND pm.meta_key = '_stock_status')
                WHERE %s %s %s
                %s",
            $phone_only,
            $search_query,
            $dedicated_query,
            $order_query
        );

		$wpdb->get_col($query);
		$results_count = $wpdb->num_rows;

        $results = $wpdb->get_results(sprintf("%s %s",$query,sprintf('LIMIT 20 OFFSET %d',(($this->p - 1) * 20))));

        //Pagination.
        $this->_pagination_args = array(

            'total_items'   => $results_count,
            'current_page'  => $this->p
        );

        $this->_pagination_args['total_pages'] = ceil($this->_pagination_args['total_items'] / 20);

        $this->items = $results;
    }
}
?>