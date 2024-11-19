<?php 
/*
 * Displaying Tags Template
 *
 * @package bw-wiredstore
 */

get_header(); ?>

<header>
	<h1>
		<i class = 'bwi bwi-tag'></i> 
		<?php _e("Tag",'bw');?>
	</h1>
	<h2>
		<?php single_tag_title(); ?>
	</h2>
	<?php echo tag_description();?>
</header>
<hr />

<main id = 'main'>
	<?php get_template_part('inc/post','thumbnail');?>
</main>

<section id = 'pagination'>
	<?php
		define("CURR_PAGE",empty(get_query_var("paged")) ? 1:get_query_var("paged"));
		define("MAX_PAGES",empty($max_num_pages) ? 1:$max_num_pages);
		get_template_part("inc/pagination/multi");
	?>
</section>

<?php get_footer(); ?>