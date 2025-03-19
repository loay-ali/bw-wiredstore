<?php

//require_once __DIR__ .'/../../backorders.php';

class BW_Product_Shipping_Products extends WP_List_Table {

    public $s,$order,$orderby,$p,$location,$counter,$gov_titles,$enabled_only;

    function __construct() {

        parent::__construct(array(

            'singular'  => 'شحن المنتج',
            'plural'    => 'شحن المنتجات',
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
        $this->orderby = (empty($_GET['orderby']) || !is_string($_GET['orderby']) || !in_array($_GET['orderby'],['product','locations','enable'])) ? 'product':$_GET['orderby'];
    }

     function get_columns() {

        return array(

            'id'            => '#',
            'product'       => 'المنتج',
            'enable'        => 'الشحن الخاص',
            'locations'      => 'المناطق المتاحة خصيصاً',
            'operations'    => ''
        );
    }

    function get_sortables() {

        return array(

            'id'        => array('id',true),
            'product'   => array('name',false),
            'locations'   => array('locations',false),
            'enable'   => array('enable',false)
        );
    }

    function column_default($item,$col_name) {

        switch( $col_name ){

            case 'id':
                return $this->counter++;
            break; 

			case 'product':
				
				return $item['title'];
			break;

            case 'enable':

                return $item['enable'] == true ? "<i style = 'color:#28a745;' class = 'dashicons dashicons-yes'></i>":"<i style = 'color:#dc3545;' class = 'dashicons dashicons-no'></i>";
            break;

            case 'locations':

                ob_start();
                echo "<ul>";
                foreach( $item['locations'] as $gov => $val ) {

                    if( array_key_exists($gov,$this->gov_titles) )
                        echo "<li><strong>". $this->gov_titles[$gov] ."</strong></li>";

                    if( is_array($val) ) {

                        echo "<ul>";

                        foreach( array_unique($val) as $city ) {

                            echo "<li>-- ". $city ."</li>";
                        }

                        echo "</ul>";
                    }
                }
                echo '</ul>';

                $tmpContent = ob_get_contents();
                ob_end_clean();
                
                return $tmpContent;

            break;

            case 'operations':

                return "<div class = 'bw-operations'><button type = 'button' class = 'button bw-open-window' bw-enabled = '". ($item['enable'] == true ? 'on':'off') ."' bw-product-locations = '". $this->deep_implode($item['locations']) ."' bw-product-title = '". $item['title'] ."' bw-product-id = '". $item['product_id'] ."' bw-window = 'bw-edit-product-locations'><i class = 'dashicons dashicons-edit'></i></button><!-- <button type = 'button' class = 'button' style = 'color:#dc3545;border-color:#dc3545;margin-inline-start:5px;'><i class = 'dashicons dashicons-trash'></i></button></div> -->";
            break;
        }
    }

    private function deep_implode($arr) {

        $tmp = [];

        foreach( $arr as $code => $item ) {
            if( is_array($item) )
                array_push($tmp,implode(',',array_map(function($ele) use ($code) { return $code .'_'. trim($ele);},$item)));
            else
                if( array_key_exists($code,$this->gov_titles) )
                    array_push($tmp,$code);
        }

        return implode(',',$tmp);
    }

    private function deep_array_search($needle,$haystack) {

        foreach( $haystack as $single_array ) {

            if( is_array($single_array) && in_array($needle,$single_array) )
                return true;
            elseif( !is_array($single_array) && $single_array == $needle )
                return true;
        }

        return false;
    }

    function get_items() {

        global $wpdb;

        $this->p = empty($_GET['paged']) ? 1:absint($_GET['paged']);//Define Current Page.

        $this->location = empty($_GET['location']) ? '':htmlspecialchars($_GET['location']);
        $this->s = empty($_GET['s']) ? '':htmlspecialchars($_GET['s']);
        $this->enabled_only = empty($_GET['enabled-only']) ? false:true;

        $sortables = $this->get_sortables();

        $this->_column_headers = array(

            $this->get_columns(),
            array(),
            $sortables,
            'id'
        );

        $filters = '';
        if( !empty($this->s) )
            $filters = sprintf('AND post_title LIKE "%s"','%'. $this->s .'%');

        $sorting = ($this->orderby == 'product' ? "ORDER BY post_title ". ($this->order == 'desc' ? 'DESC':'ASC'):'');

        $query = sprintf("SELECT post_title,post_id,meta_value FROM
                {$wpdb->posts} p
                LEFT JOIN {$wpdb->postmeta} pm ON(p.ID=pm.post_id AND pm.meta_key = 'bw_product_shipping')
            WHERE
                p.post_type = 'product'
                %s
                %s"
                ,$filters
                ,$sorting);

        $results = [];

        foreach( $wpdb->get_results($query) as $meta ) {

            $metaUnserialized = is_null($meta->meta_value) ? ['enable' => false,'data' => []]:unserialize($meta->meta_value);

            if( !empty($this->enabled_only) && $metaUnserialized['enable'] == false )
                continue;

            if( !empty($this->location)
            &&  ((substr($this->location,0,4) == 'all-' && !array_key_exists(substr($this->location,4),$metaUnserialized['data']))
                ||
                (!$this->deep_array_search($this->location,$metaUnserialized['data'])))
            )
                continue;

            array_push($results,array(
                'product_id'    => $meta->post_id,
                'title'         => $meta->post_title,
                'enable'        => $metaUnserialized['enable'],
                'locations'     => $metaUnserialized['data']
            ));
        }

        if( $this->orderby == 'locations' ) {
            uasort($results,function($a,$b){
                
                $count_a = count($a['locations'],COUNT_RECURSIVE);
                $count_b = count($b['locations'],COUNT_RECURSIVE);

                return $this->order == 'asc' ? ($count_a > $count_b ? 1:-1):($count_a < $count_b ? 1:-1);
            });
        }

        if( $this->orderby == 'enable' ) {
            uasort($results,function($a,$b){

                return $this->order == 'asc' ? ($a['enable'] && $b['enable'] == false ? 1:-1):($a['enable'] == false && $b['enable'] ? 1:-1);
            });
        }

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