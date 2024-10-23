<?php

function bwbw_get_fonts($s,$displayText) {
	
	$link = "https://www.googleapis.com/webfonts/v1/webfonts?key=";
	
	return array();//To Be Changed.
}

$currentFont = get_theme_mod('bw_bw_font_family','');
$searchFont = empty($_GET['s']) ? '':sanitize_text_field($_GET['s']);
$displayText = empty($_GET['display-text']) ? __('Hello World','bw'):esc_html($_GET['display-text']);

$foundFonts = bwbw_get_fonts($searchFont,$displayText);

$pagination = array(
	
	'current'	=> empty($_GET['p']) ? 0:absint($_GET['p']),
	'max'		=> 3 //To Be Changed
);
?>
<section class = 'wrap'>

	<header style = 'display:flex;align-items:center;justify-content:center;'>
		
		<form method = 'GET'>
			<!-- Search Font -->
			<input
				type = 'search' 
				placeholder = '<?php _e("Search Fonts...",'bw');?>'
				name = 's'
				value = '<?php echo $searchFont;?>'
				class = 'wrap' style = 'margin:0;' />
			<button type = 'submit' class = 'button button-primary'>
				Search
			</button>
			
			<span style = 'margin:0 10px'>-</span>
			
			<!-- Display Text -->
			<input
				type = 'text'
				name = 'display-text'
				value = '<?php echo $displayText;?>'
				placeholder = '<?php _e("Some Text To Display",'bw');?>' />
			<button type = 'submit' class = 'button button-primary'>
				&check;
			</button>
			
			<span style = 'margin:0 10px'>-</span>
			
			<!-- Sorting -->
			<?php $sorts = array(
			
				'popularity'	=> "Popularity",
				'a-z'			=> "Alphabatical",
				'z-a'			=> "Reverse Alpha.",
				'release'		=> "Release",
				'update'		=> "Update"
			);?>
			<label for = 'sort'>
				<?php _e("Sort By",'bw');?>
			</label>
			<select name = 'sort' id = 'sort'>
			<?php foreach($sorts as $key => $s):?>
			
				<option value = '<?php echo $key;?>'>
					<?php _e($s,'bw');?>
				</option>
			
			<?php endforeach;?>
			</select>
			
			<input type = 'hidden' name = 'page' value = 'bwbw_google-fonts-page' />
		</form>
		
	</header>

	<hr />

	<section>
		<table class = 'widefat'>
			<thead>
				<tr>
					<td></td>
					<th>
						<?php _e("Font Name",'bw');?>
					</th>
					<th>
						<?php _e("Font Display",'bw');?>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php if( count($foundFonts) == 0 ):?>
			
				<tr>
					<th colspan = '3'>
						<?php _e("No Fonts Founded",'bw');?>
					</th>
				</tr>
			<?php else:
			
				foreach(array(array('Font 1','Test 1'),array('Font 2','Test 2')) as $ind => $font):?>
				<tr style = 'cursor:pointer;<?php echo $ind == 0 ? 'outline:2px solid #007BFF':'';?>'>
					<td><?php echo $ind + 1;?></td>
					<td><?php echo $font[0];?></td>
					<td><?php echo $font[1];?></td>
				</tr>
				<?php endforeach;
				
			endif;?>
			</tbody>
		</table>
		
		<hr />
		
		<section id = 'pagination' style = 'display:flex;align-items:center;justify-content:center;'>
		<a
			class = 'button'
			style = 'padding:10px;padding-bottom:0;'
			href = '#'>
			<i class = 'dashicons dashicons-arrow-left-alt'></i>
		</a>
		<strong style = 'padding:10px;font-size:20px;'><?php echo implode('/',$pagination);?></strong>
		<a
			class = 'button'
			style = 'padding:10px;padding-bottom:0;'
			href = '#'>
			<i class = 'dashicons dashicons-arrow-right-alt'></i>
		</a>
		</section>
		
	</section>

</section>