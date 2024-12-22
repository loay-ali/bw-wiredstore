<footer>
	<?php if( !empty($args['prev']) ):?>
		<button class = 'bwa-btn' type="submit" form = 'setup-wizard-content' name = 'bw-submit' value = 'prev'>
			<?php echo $args['prev'];?>
		</button>
	<?php endif;?>

	<?php if( !empty($args['next']) ):?>
		<button class = 'bwa-btn-primary' type="submit" form = 'setup-wizard-content' name = 'bw-submit' value = 'next'>
			<?php echo $args['next'];?>
		</button>
	<?php endif;?>
</footer>