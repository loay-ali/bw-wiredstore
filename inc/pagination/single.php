<section id = 'pagination' class = 'single'>
<?php
	$lang_dir = is_rtl() ? array('right','left'):array('left','right');

	if(get_previous_post_link()) {
		previous_post_link("<button title = '". __("Previous Page",'bw') ."'><i class = 'fas fa-caret-". $lang_dir[0] ."'></i> %link</button>");
	}else {
		echo "<button title = '". __("No Previous Page",'bw') ."' disabled><i class = 'fas fa-caret-". $lang_dir[0] ."'></i></button>";
	}
	
	if(get_next_post_link()) {
		next_post_link("<button title = '". __("Next Page",'bw') ."'>%link <i class = 'fas fa-caret-". $lang_dir[1] ."'></i></button>");
	}else {
		echo "<button title = '". __("No Next Page",'bw') ."' disabled><i class = 'fas fa-caret-". $lang_dir[1] ."'></i></button>";
	}
?>
</section>