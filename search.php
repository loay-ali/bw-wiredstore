<?php 
/**
 * Search Page Template
 *
 * @package bw-wiredstore
*/
	get_header(); 
	
	$currPage = get_query_var('paged') ? absint(get_query_var('paged')):1;

	$q = new WP_Query(array(
		"s" 				=> get_search_query(),
		"paged" 			=> $currPage,
		"posts_per_page" 	=> 20,
		"order" 			=> get_query_var('order')?get_query_var('order'):'ASC',
		'orderby' 			=> get_query_var('orderby')?get_query_var('orderby'):'date'
		)
	);
?>
<header>
<?php
	//Bring a Search Form In The Top
	get_search_form();

	//Show Total Results Count.
	?>
	<h2>
		<?php printf(_n("%s Result","%s Results",$q->found_posts),$q->found_posts);?>
	</h2><?php
	
	//Sorting Options.
	get_template_part("inc/sort");
?>

</header><hr />

<main id = 'main'>
	<?php if($q->have_posts()):
		while($q->have_posts()):
			$q->the_post();?>
			<a href = '<?php echo get_permalink();?>'>
				<?php the_post_thumbnail('medium');?>
				<h2><?php echo get_the_title()?></h2>
				<h4>
					<time datetime = '<?php the_date('Y-m-d H:i:s');?>' pubdate>
						<?php echo get_the_date();?>
					</time>
				</h4>
				<?php the_excerpt();?>
			</a>		
	<?php
		endwhile;
	endif;?>
</main>

<?php
//Pagination Constants.
define("MAX_PAGES",$q->max_num_pages);
define("CURR_PAGE",$currPage);

wp_reset_postdata();

//Pagination.
get_template_part("inc/pagination/multi");

?>

<?php get_footer(); ?>