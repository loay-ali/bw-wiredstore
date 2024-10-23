<?php

class BW_Customize_Components {

	static function number($args = array()) {

		$parsed_args = wp_parse_args( $args, array(
			'init'	=> '',

			'min'	=> null,
			'max'	=> null,
			
			'units'	=> array(),

			'name'	=> '',
			'id'	=> ''
		) );

		?>

		<input
			type	= "number"
			name	= "<?php echo $parsed_args['name'];?>[value]"
			id		= "<?php echo $parsed_args['id'];?>"
			value	= "<?php echo $parsed_args['init'];?>"
			<?php echo (is_null($parsed_args['min']) ? '':"min = '". intval($parsed_args['min']) ."'");?>
			<?php echo (is_null($parsed_args['max']) ? '':"max = '". intval($parsed_args['max']) ."'");?> />

		<?php if( is_array($parsed_args['units']) && count($parsed_args['units']) > 0 ):?>
		<select name="<?php echo $parsed_args['name'];?>[unit]">
			<?php foreach( $parsed_args['units'] as $unit_code => $unit_title ):?>
			<option value="<?php echo $unit_code;?>"><?php echo $unit_title;?></option>
			<?php endforeach;?>
		</select>
		<?php endif;?>

		<?php
	}
}
?>