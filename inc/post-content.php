<header>
	<h1>
		<?php echo get_the_title(); ?>
	</h1>
	<div class = 'post-thumbnail'>
		<?php the_post_thumbnail('medium'); ?>
	</div>

	<h2><?php echo get_the_author(); ?></h2>
</header>
<?php

//Get The Date.
$y = get_the_date("Y");
$m = get_the_date("m");
$d = get_the_date("d");

?>
<h3>
	<time datetime = '<?php echo get_the_date('Y-m-d H:i:s');?>'>
		<a href = '<?php echo get_day_link($y,$m,$d); ?>'>
			<?php echo get_the_date(); ?>
		</a>
	</time>
</h3>

<h4>
	<b><?php _e("Categories :",'bw');?></b>
	<?php the_category(" , "); ?>
</h4>

<h4>
	<?php the_tags('<b>'.__('Tags :','bw').'</b>'); ?>
</h4>
<hr />

<?php do_action('bw-post-share'); ?>

<p><?php echo get_the_content(); ?></p> 