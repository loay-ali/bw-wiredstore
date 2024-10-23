<?php 
	if( have_posts() ):
		while( have_posts() ):
			the_post();
			?>
			
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
			<hr />
			<?php
		endwhile;
	else:
		_e("No Results Found",'bw');
	endif;
?>