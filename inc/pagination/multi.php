<section id = 'pagination'>

	<?php
	
		$usingPermalink = get_option('permalink_structure');
		
		$link = add_query_arg('',false);
		
		if( $usingPermalink != '' ) {//If It Use Pretty Link.
			
			if( ! strstr($link,'/page/') ) {

				$queryStr = esc_html($_SERVER['QUERY_STRING']);
				$queryStr = (strlen($queryStr) != 0 ? '?':'') . $queryStr;
	
				$link = explode('?',$link)[0] .'page/[page_num]/'. $queryStr;
			}else {
				
				$link = str_replace('/page/'. CURR_PAGE .'/','/page/[page_num]/',$link);
			}
		}
	?>

	<?php if(MAX_PAGES > 1) :
		
		$lang_dir = is_rtl() ? array('right','left'):array('left','right');
		
		if( CURR_PAGE > 1 ) {
			
			echo "<a class = 'button' href = '". str_replace('[page_num]',CURR_PAGE - 1,$link) ."' title = '". __("Previous Page",'bw') ."'><i class = 'fas fa-caret-". $lang_dir[0] ."'></i></a>";
		}
		
		if(CURR_PAGE == 1) {
			echo "<button class = 'active'>1</button> ";
			for($p = 2;$p <= min(5,MAX_PAGES);$p++) {
				echo "<a class = 'button' title = '". __("Page Number ".$p,'bw') ."' href = '". str_replace('[page_num]',$p,$link) ."'>". $p ."</a> ";
			}
		}elseif(CURR_PAGE == MAX_PAGES) {
			for($p = max(CURR_PAGE-4,1);$p <= MAX_PAGES;$p++) {
							
				echo "<a class = 'button". ($p == CURR_PAGE ? ' active':'') ."' href = '". str_replace('[page_num]',$p,$link) ."' title = '". ($p == CURR_PAGE ? __("The Current Page",'es'):__("Page Number ". $p,'es')) ."'>". $p ."</a> ";
			}	
		}else {

			for($p = max(CURR_PAGE - 2,1);$p <= min(CURR_PAGE + 2,MAX_PAGES);$p++) {
				
				echo "<a class = 'button". (CURR_PAGE == $p ? ' active':'') ."' href = '". str_replace('[page_num]',$p,$link) ."' title = '". ($p == CURR_PAGE ? __("Current Page",'bw'):__("Page Number ". $p)) ."'>". $p ."</a>";
			}
			
		}
		
		if(CURR_PAGE != MAX_PAGES) {
			echo "<a class = 'button' href = '". str_replace('[page_num]',CURR_PAGE + 1,$link) ."' title = '". __("Next Page",'bw') ."'><i class = 'fas fa-caret-". $lang_dir[1] ."'></i></a>";
		}
		
	endif;?>

</section>