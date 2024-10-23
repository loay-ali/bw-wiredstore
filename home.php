<?php 
/*
 * Home Page Template
 *
 * @package bw-wiredstore
 */
get_header(); ?>

<?php 
	if(is_home()) {
		for($w = 1;$w <= 4;$w++) {
			if(is_active_sidebar("home-". $w))
				dynamic_sidebar("home-" . $w);
		}
	}
?>

<?php get_footer(); ?>