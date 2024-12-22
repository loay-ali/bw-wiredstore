<form method = 'POST' id = 'setup-wizard-content'>
	<?php foreach( $args['data']['data'] as $slug => $d ) {
		switch( $d['type'] ) {
			case 'radio-imgs':?>

				<h3>
					<?php echo $d['title'];?>
				</h3>
				<div class = 'bwa-radio-imgs'>
				<?php foreach( $d['values'] as $input_id => $val ):?>
					<label for = '<?php echo $input_id;?>'>
						<span><?php echo $val['title'];?></span>
						<img
							src		= '<?php echo get_template_directory_uri(  ) .'/assets/imgs/setup-wizard/'. $val['image'];?>'
							width	= '100' />
						<input
							type	= 'radio'
							name	= '<?php echo $slug;?>'
							id		= '<?php echo $input_id;?>'
							value	= '<?php echo $input_id;?>'
							<?php echo !empty($d['required']) ? "required":"";?> />
					</label>
				<?php endforeach;?>
				</div>

			<?php break;

			case 'color':?>
				<label for="bw_color_<?php echo $slug;?>">
					<span><?php echo $d['title'];?></span>
					<input
						type	= "color"
						name	= "bw_color_<?php echo $slug;?>"
						id		= "bw_color_<?php echo $slug;?>"
						<?php echo empty($d['default']) ? "":"value = '". $d['default'] ."'";?> />
				</label>
			<?php break;

			case 'checkbox-imgs':?>
				<h3>
					<?php echo $d['title'];?>
				</h3>
				<div class = 'bwa-checkbox-imgs'>
				<?php foreach( $d['values'] as $input_id => $val ):?>
					<label for="<?php echo $input_id;?>">
						<span><?php echo $val['title'];?></span>
						<img src="<?php echo get_template_directory_uri() .'/assets/imgs/setup-wizard/'. $val['image'];?>" width = '100'/>
						<input
							type	= "checkbox"
							name	= "<?php echo $slug;?>"
							id		= "<?php echo $input_id;?>"
							value	= '<?php echo $input_id;?>'
							<?php echo !empty($d['required']) ? "required":'';?> />
					</label>
				<?php endforeach;?>
				</div>
			<?php break;
			}
		}
	?>

	<input
		type	= "hidden"
		name	= "bw-is-saving"
		value	= "<?php echo $args['stage'];?>" />
	<?php wp_nonce_field( 'bw-saving-admin', '_wpnonce' );?>
</form>