<?php
/*
* @package kidz-r-fun
*/
get_header(); ?>

<h2>
	<?php echo get_the_title(); ?>
</h2>
<?php 

the_content(); 

if( comments_open() ) {
	
	comments_template();
}

get_footer(); ?>