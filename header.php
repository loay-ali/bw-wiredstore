<?php
/*
 * Main Header Template
 *
 * @package bw-wiredstore
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<title><?php echo esc_html(get_bloginfo("title")) . wp_title('|',false); ?></title>
		<meta charset = "<?php bloginfo('charset');?>" />
		<meta name = 'viewport' content = 'width=device-width,initial-scale=1.0' />
		<meta name = 'robots' content = 'index, follow' />
		<meta name = 'description' content = '<?php echo get_option('blogdescription');?>' />
		<link rel = 'pingback' href = '<?php echo esc_attr(get_bloginfo('pingback_url')); ?>' />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> noJs>
	<?php if(function_exists('wp_body_open')) { wp_body_open(); }?>
		<?php if( boolval(get_theme_mod('bw-loading-screen-enable',true)) ):?>
			<div
				id = 'loading'
				style = 'width:100%;height:100%;top:0;left:0;background:<?php echo get_theme_mod('bw_color_'. get_theme_mod('bw-loading-screen-bg','white'),'#FFF');?>;color:<?php echo get_theme_mod('bw_color_'. get_theme_mod('bw-loading-screen-fg','black'),'#000');?>;z-index:9999999;display:none;'>
				<?php bw_loading_screen();?>
			</div>
			<script>document.getElementById("loading").style.display='block';</script>
		<?php endif;?>
	
		<header id = 'main-header'>
		
			<section id = 'site-identity'>
				
				<a href = '<?php echo esc_url(get_bloginfo('url')); ?>'>
			
					<?php
					if(get_theme_mod('header-logo-display',true)) {
						if(has_custom_logo()) {
							echo wp_get_attachment_image(get_theme_mod('custom_logo'));
						}
					} 
					?>
						
					<h1 id = 'site-title'>
						<?php echo empty(get_theme_mod("header-title")) ? esc_html(get_bloginfo('name')):esc_html(get_theme_mod('header-title')); ?>
					</h1>
					
				</a>
			
			</section>
			
			<section id = 'header-widgets' class = 'screen-only'>
				<?php
					for($w = 1;$w <= 2;$w++) {
						echo "<div id = 'header-widget-$w'>";
						
						if(is_active_sidebar("header-" . $w)) {
							dynamic_sidebar("header-" . $w);
						}
						echo "</div>";
					}
				?>
			</section>
			
			<button 
				class = 'phone-only requireJs'
				id = 'open-menu' 
				title = '<?php _e("Open Menu",'bw');?>'>
				<i class = 'bwi bwi-menu-bars'></i>
			</button>
		
		</header>
		
			<section id = 'header-menu' class = 'requireJs' toggle-effect = '<?php echo get_theme_mod('bw-menu-toggle-effect','none');?>'>

				<button
					class = 'phone-only' 
					id = 'close-menu' 
					title = '<?php _e("Close Menu",'bw');?>'>
					<i class = 'bwi bwi-cross'></i>
				</button>
				<?php
					if(has_nav_menu("primary")) {
						
						wp_nav_menu(array(
							
							'theme_location' => "primary"
						));
					}
				?>
			</section>
		
			<noscript>
				<ul id = 'noJsMenu'>
				<?php
				
					if(has_nav_menu('primary')) {
					
						wp_nav_menu(array(
							
							'theme_location'	=> 'primary'
						));
					}?>
				</ul>
			</noscript>
		
		<section id = 'main-container'>
		
		<?php do_action("bw_theme_main_container");?>