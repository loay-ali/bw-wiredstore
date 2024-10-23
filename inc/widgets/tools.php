<?php 

function bwbw_bg_position($input_id,$input_name) { ?>
    
<div class="background-position-control" style = 'width:240px;'>
    <div class="button-group">
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="left top">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-left-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Top Left</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="center top">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-up-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Top</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="right top">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Top Right</span>
        </label>
    </div>
    <div class="button-group">
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="left center">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-left-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Left</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="center center">
            <span class="button display-options position"><span class="background-position-center-icon" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Centre</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="right center">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Right</span>
        </label>
    </div>
    <div class="button-group">
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="left bottom">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-left-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Bottom Left</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="center bottom">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-down-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Bottom</span>
        </label>
        <label>
            <input class="screen-reader-text" id = '<?php echo $input_id;?>' name="<?php echo $input_name;?>" type="radio" value="right bottom">
            <span class="button display-options position"><span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span></span>
            <span class="screen-reader-text">Bottom Right</span>
        </label>
    </div>
</div>

<?php }

function bwbw_color_picker($input_id,$input_name,$val) {?>

	<input 
		type = 'text' 
		class = 'bw-color-picker' 
		id = '<?php echo $input_id;?>'
		name = '<?php echo $input_name;?>'
		value = '<?php echo $val;?>'
		style = 'display:block'/>
	
	<?php $btnStyle = 'margin:1.5px;width:25px;height:25px;border-radius:5px;border:none;cursor:pointer;'; ?>
	<section style = 'display:flex;justify-content:flex-start;'>
		<?php for($col = 1;$col <= 5;$col++):
			$theCol = get_theme_mod('bw-theme-color-'. $col,null);
			if( $theCol != null ):?>
			<button 
				type 			= 'button' 
				style 			= "background-color:<?php echo $theCol;?>;<?php echo $btnStyle;?>"
				class 			= 'bw-change-color'
				data-bw-color 	= "<?php echo $theCol;?>"
				></button>
		<?php endif;endfor;?>
	</section>
	<?php }?>