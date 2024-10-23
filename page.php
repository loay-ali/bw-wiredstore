<?php 
/**
 * Page Main Template
 *
 * @package bw-wiredstore
*/
get_header(); ?>

<header id = 'page-header'>
	<h2>
		<?php echo get_the_title(); ?>
	</h2>
</header>
<hr />

<section id = 'page-content'>
	<?php the_content(); ?>
</section>

<?php get_footer(); ?>