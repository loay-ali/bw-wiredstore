<?php 
/*
 * Display a Single Template ( Page , Post , Tag , Category , Etc. )
 *
 * @package bw-wiredstore
 */
get_header(); ?>

<?php get_template_part('inc/post','content');?>

<!-- Comments -->
<?php if(comments_open()) {
	comments_template();
}else {
	?>
	<h4>
		<?php _e("Comments Are Closed For This Post",'bw'); ?>
	</h4>
	<?php
}

?><hr />
<!-- Comments End -->

<!-- Pagination -->
<?php get_template_part("inc/pagination/single"); ?>

<?php get_footer(); ?>