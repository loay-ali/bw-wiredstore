<?php

class BW_Backorder_Products_Form_Table extends WP_List_Table {

    public $order_by,$order,$s,$dedicated_inputs,$paged;

    function __construct() {

        parent::__construct(array(

            'singular'  => 'منتج',
            'plural'    => 'المنتجات',
            'ajax'      => false
        ));
    }

    function get_columns() {

        return array(

            //'cb'        => "<input type = 'checkbox' />",
            'id'            => 'ID',
            'product'       => 'اسم المنتج',
            'orders'        => 'الطلبات المسبقة',
            'unsent_orders' => 'الطلبات غير المرسلة',
            'status'        => 'الحالة',
        );
    }

    function get_sortables() {

        return array(

            'id'            => array('pr.ID',false),
            'orders'        => array('order_quantity',true),
            'product'       => array('pr.post_title',false),
            'unsent_orders' => array('undelivered_quantity',false),
            'status'        => array('pm.meta_value',false)
        );
    }

    function column_default($item,$col_name) {

        switch($col_name) {

            case 'id':
                return $item->product_id;
            break;

            case 'unsent_orders':
                return $item->undelivered_quantity;
            break;

            case 'product':
                return "<a href = '". get_edit_post_link($item->product_id) ."'>". $item->post_title ."</a>";
            break;

            case 'status':
                return $item->stock == 'instock' ? 'متوفر':'غير متوفر';
            break;

            case 'orders':
                return $item->order_quantity;
            break;
        }
    }

    function get_items() {

        global $wpdb;

        $this->paged = empty($_GET['paged']) ? 1:absint($_GET['paged']);

        $sortables = $this->get_sortables();

        $this->_column_headers = array(

            $this->get_columns(),
            array(),
            $sortables,
            'id'
        );

        $this->order_by = (empty($_GET['orderby']) || !array_map(function($ele) { return $ele[0];},$sortables)) ? 'order_quantity':$_GET['orderby'];
        $this->order = (empty($_GET['order']) || !in_array($_GET['order'],array('asc','desc'))) ? 'desc':$_GET['order'];

        $this->dedicated_inputs['search'] = empty($_GET['s']) ? '':htmlspecialchars($_GET['s']);
        $this->dedicated_inputs['stock'] = (empty($_GET['bw-stock-only']) || !in_array($_GET['bw-stock-only'],array('outofstock','instock'))) ? '':$_GET['bw-stock-only'];

        $dedicated_query = empty($this->dedicated_inputs['search']) ? '(1 = 1)':sprintf("(pr.post_title LIKE '%s')",'%'. $this->dedicated_inputs['search'] .'%');
        $dedicated_query .= empty($this->dedicated_inputs['stock']) ? ' AND (1 = 1)':($this->dedicated_inputs['stock'] == 'instock' ? " AND pm.meta_value = 'instock'":"AND pm.meta_value = 'outofstock'");

        $order_query = "ORDER BY {$this->order_by} {$this->order}";

        $results = $wpdb->get_results(sprintf(
            "SELECT 
                bo.*,pr.post_title,pm.meta_value as stock,COUNT(bo.ID) as order_quantity,COUNT(CASE WHEN bo.status = 1 THEN 1 END) as undelivered_quantity
                FROM {$wpdb->prefix}bw_backorders bo
                LEFT JOIN {$wpdb->posts} pr ON(pr.ID=bo.product_id)
                LEFT JOIN {$wpdb->postmeta} pm ON(pr.ID = pm.post_id AND pm.meta_key = '_stock_status')
                WHERE %s
                GROUP BY pr.ID
                %s",
                $dedicated_query,
                $order_query
        ));

        $this->items = array_slice($results,(($this->paged - 1) * 20),20);

        $this->_pagination_args = array(

            'total_items'   => count($results),
            'current_page'  => $this->paged
        );

        $this->_pagination_args['total_pages'] = ceil($this->_pagination_args['total_items'] / 20);
    }
}