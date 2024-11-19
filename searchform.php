<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" class="search-field" name="s" placeholder="<?php _e("Search",'bw'); ?>" value="<?php echo get_search_query(); ?>">
    <button type="submit" title = '<?php _e("Search",'bw');?>'>
		<i class = 'bwi bwi-search'></i>
	</button>
	
	<?php if(is_search()): ?>
		<hr />
	
		<?php $order = get_query_var('order') ? 'ASC':get_query_var('order');  ?>
		<label for = 'search-order'><?php _e("Order :",'bw');?></label>
		<select id = 'search-order' name = 'order'>
			<option <?php selected('ASC',$order);?> value = 'ASC'><?php _e("A-Z",'bw'); ?></option>
			<option <?php selected('DESC',$order);?> value = 'DESC'><?php _e("Z-A",'bw'); ?></option>
		</select>
		
		<?php $orderby = get_query_var('orderby') ? 'date':get_query_var('orderby'); ?>
		<label for = 'search-order-by'><?php _e("Order By :",'bw');?></label>
		<select id = 'search-order-by' name = 'orderby'>
			<option <?php selected($orderby,'title');?> value = "title"><?php _e("Title",'bw'); ?></option>
			<option <?php selected($orderby,'date');?> value = 'date'><?php _e("Date",'bw'); ?></option>
			<option <?php selected($orderby,'author');?> value = 'author'><?php _e("Author",'bw'); ?></option>
		</select>
		
	<?php endif; ?>
	
	<?php if(class_exists("woocommerce",false)):?>
		<input type = 'hidden' name = 'post_type' value = 'product' />
	<?php else:?>
		<input type = 'hidden' name = 'post_type' value = 'post' />
	<?php endif; ?>
</form>