<?php 
/**
 * Displaying Date Template
 *
 * @package bw-wiredstore
 */
get_header(); ?>

<header>
	<h1>
		<i class = 'fas fa-calendar-alt'></i> - <time datetime = '<?php echo get_the_date('Y-m-d H:i:s');?>'><?php echo get_the_date(); ?></time>
	</h1>
</header>
<hr />

<main id = 'main'>
	<?php get_template_part('inc/post','thumbnail');?>
</main>

<section id = 'pagination'>
	<?php
		define('CURR_PAGE',empty(get_query_var("paged") ? 1:get_query_var('paged')));
		define("MAX_PAGES",empty($max_num_pages) ? 1:$max_num_pages);
		
		get_template_part("inc/pagination/multi"); 
	?>
</section>

<?php get_footer(); ?>