<?php
global $product;

$qa = get_option('bw_content_qa',array());
$qa_enabled = get_post_meta($product->get_id(),'bw_qa_enable',true);

$excluded = (array)get_post_meta( $product->get_id() ,'bw_excluded_qa',true);

foreach( $qa as $code => $entry ) {
    if( in_array($code,$excluded) )
        unset($qa[$code]);
}

if( ! is_null($qa_enabled) && $qa_enabled != "" ) {
    $qa = array_filter($qa,function($key) use ($qa_enabled) {

        return in_array($key,$qa_enabled);
    },ARRAY_FILTER_USE_KEY);
}

if( count($qa) > 0 ): ?>

<section class = "bw-container" style = 'width:500px;'>

    <?php foreach($qa as $item):?>
    <section class = "bw-toggle-section">
        <?php if( ! empty($item['title']) ):?>
        <header>
            <?php echo $item['title'];?>
            <i class="bwi bwi-arrow-bottom"></i>
        </header>
        <?php endif;?>

        <?php if( ! empty($item['content']) ):?>
        <section>
            <?php echo $item['content'];?>
        </section>
        <?php endif;?>
    </section>
    <?php endforeach; ?>
</section>

<?php else:?>
    <strong>
        لا توجد اسئلة شائعة لهذا المنتج
    </strong>
<?php endif;?>