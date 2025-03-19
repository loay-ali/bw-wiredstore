<?php

//require_once __DIR__ .'/../../backorders.php';

class BW_Product_Shipping_Locations extends WP_List_Table {

    public $s,$order,$order_by,$p,$gov,$counter;

    private $gov_titles;

    function __construct() {

        parent::__construct(array(

            'singular'  => 'منطقة',
            'plural'    => 'المناطق',
            'ajax'      => false
        ));

        $this->counter = (20 * ((empty($_GET['paged']) || !is_string($_GET['paged']) ? 1:absint($_GET['paged'])) - 1)) + 1;
        $this->gov_titles = [
            'EGC'   => 'القاهرة',
            'EGALX' => 'الإسكندرية',
            'EGGZ'  => 'الجيزة',
            'EGMNF' => 'المنوفية',
            'EGGH'  => 'الغربية',
            'EGKB'  => 'الفليوبية',
            'EGBH'  => 'البحيرة',
            'EGDK'  => 'الدقهلية',
            'EGSHR' => 'الشرقية',
            'EGMT'  => 'مطروح',
            'EGASN' => 'أسوان',
            'EGWAD' => 'الوادى الجديد',
            'EGSUZ' => 'السويس',
            'EGSIN' => 'شمال سيناء',
            'EGSHG' => 'سوهاج',
            'EGPTS' => 'بورسعيد',
            'EGMN'  => 'المنيا',
            'EGLX'  => 'الأٌقصر',
            'EGKN'  => 'قنا',
            'EGKFS' => 'كفر الشيخ',
            'EGJS'  => 'جنوب سيناء',
            'EGIS'  => 'الإسماعيلية',
            'EGFYM' => 'الفيوم',
            'EGDT'  => 'دمياط',
            'EGBNS' => 'بنى سويف',
            'EGAST' => 'اسيوط',
            'EGBA'  => 'البحر الأحمر'
        ];

        $this->order = (empty($_GET['order']) || !is_string($_GET['order']) || !in_array($_GET['order'],['asc','desc'])) ? 'asc':$_GET['order'];
        $this->order_by = (empty($_GET['orderby']) || !is_string($_GET['orderby']) || !in_array($_GET['orderby'],['name','products'])) ? 'name':$_GET['orderby'];
    }

     function get_columns() {

        return array(

            'id'            => '#',
            'location'      => 'المنطقة',
            //'parent'        => 'جزء من',
            'products'      => 'المنتجات المتاحة خصيصاً',
            'operations'    => ''
        );
    }

    function get_sortables() {

        return array(

            'id'        => array('id',true),
			'location'	=> array('name',false),
            //'parent'    => array('',false),
            'products'  => array('products',false),
        );
    }

    function column_default($item,$col_name) {

        switch( $col_name ){

            case 'id':
                return $this->counter++;
            break; 

			case 'location':
				
				return (!empty($item['parent']) ? '-- ':''). (empty($item['parent']) ? '<strong>':''). $item['title'] .(empty($item['parent']) ? '</strong>':'');
			break;

/*             case 'parent':
                
                return empty($item['parent']) ? '-':$this->gov_titles[$item['parent']];
            break; */

            case 'products':

                return count($item['products']);
            break;

            case 'operations':

                return "<div class = 'bw-operations'><button type = 'button' class = 'button bw-open-window' bw-location-products = '". implode(',',$item['products']) ."' bw-location-title = '". $item['title'] ."' ". (!empty($item['parent']) ? "bw-parent = '". $item['parent'] ."'":'') ." bw-location-id = '". $item['id'] ."' bw-window = 'bw-edit-location-products'><i class = 'dashicons dashicons-edit'></i></button><!-- <button type = 'button' class = 'button' style = 'color:#dc3545;border-color:#dc3545;margin-inline-start:5px;'><i class = 'dashicons dashicons-trash'></i></button></div> -->";
            break;
        }
    }

     function get_items() {

        global $wpdb;

        $this->p = empty($_GET['paged']) ? 1:absint($_GET['paged']);//Define Current Page.

        $this->gov = empty($_GET['gov']) ? '':htmlspecialchars($_GET['gov']);
        $this->s = empty($_GET['s']) ? '':htmlspecialchars($_GET['s']);

        $sortables = $this->get_sortables();

        $this->_column_headers = array(

            $this->get_columns(),
            array(),
            $sortables,
            'id'
        );

        $query = "SELECT post_id,meta_value FROM
                {$wpdb->postmeta}
            WHERE meta_key = 'bw_product_shipping'";

        $results = [];
        foreach( $this->gov_titles as $code => $title ) {

            if( !empty($this->gov) && $this->gov != $code )
                continue;

            $cities = get_option('bw_sublocation_'. $code,array());

            $results[$code] = ['title' => $title,'id' => $code,'products' => []];

            foreach( $cities as $city ) {

                $results[$city['n']] = [
                    'title'     => $city['n'],
                    'id'        => $city['n'],
                    'products'  => [],
                    'parent'    => $code
                ];
            }
        }
        
        $tmpResults = $wpdb->get_results($query);
        $tmpLocations = [];

        foreach( $tmpResults as $row ) {

            $tmp = unserialize($row->meta_value);

            if( $tmp['enable'] == false )
                continue;

            foreach( $tmp['data'] as $state => $cities ) {

                if( is_array($cities) ) {//Not The Entire State

                    foreach( $cities as $city ) {
                        if(empty($results[$city]['products']) )
                            $results[$city]['products'] = array();
                        if(empty($results[$city]['products'][$row->post_id]) )
                            array_push($results[$city]['products'],$row->post_id);
                    }

                }else {//The Entire States
                    if(empty($results[$state]['products']) )
                        $results[$state]['products'] = array();
                    if(empty($results[$state]['products'][$row->post_id]) )
                        array_push($results[$state]['products'],$row->post_id);
                }
            }
        }

/*         if( !empty($this->s) ) {
            $results = array_filter($results,function($ele) {
                return strstr($ele['title'],$this->s) != false;
            });
        } */

/*         uasort($results,function($a, $b){
            if( $this->order_by == 'name' )
                return $this->order == 'asc' ? ($a['title'] < $b['title'] ? -1:1):($a['title'] > $b['title'] ? -1:1);
            elseif( $this->order_by == 'products' )
                return $this->order == 'asc' ? (count($a['products']) < count($b['products']) ? -1:1):(count($a['products']) > count($b['products']) ? -1:1);

            return 1;
        }); */

        //$results = $tmpLocations;

        //Pagination.
        $this->_pagination_args = array(

            'total_items'   => count($results),
            'current_page'  => $this->p
        );

        $this->_pagination_args['total_pages'] = ceil($this->_pagination_args['total_items'] / 20);

        $this->items = array_slice($results,($this->p - 1) * 20,20);
    }
}
?>