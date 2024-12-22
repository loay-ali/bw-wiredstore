<header>
	<div id = 'bw-theme-identity'>
		<h2>
			<?php _e("Setup Wizard",'bw');?>
		</h2>
		<img
			width	= '300'
			src		= '<?php echo bw_get_theme_logo();?>'
			alt		= '<?php _e("Theme's Logo",'bw');?>' />
	</div>

	<div id = "bw-stages-header">
		<?php foreach( $args['stages'] as $id => $stage ):?>
			<a href="<?php echo get_admin_url() .'admin.php?page=bw-ws-setup-wizard&stage='. $id;?>" <?php echo $args['stage'] == $id ? "class = 'active'":'';?>>
				<i class = 'dashicons dashicons-<?php echo $stage['icon'];?>'></i>
				<strong>
					<?php echo $stage['title'];?>
				</strong>
			</a>
		<?php endforeach;?>
	</div>
</header>