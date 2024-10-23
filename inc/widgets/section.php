<?php

class Normal_Section extends WP_Widget {
	
	function __construct() {
		parent::__construct("normal_section","Section",array("classname" => "normal_section"));
	}
	
	function form ($instance) {
		
		$head = empty($instance['head']) ? '':$instance['head'];
		
		$content = empty($instance['content']) ? '':filter_var($instance['content'],FILTER_SANITIZE_NUMBER_INT);
		
		$tag_id = empty($instance['tag-id']) ? '':$instance['tag-id'];
		
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-b-appear-on-scroll',false):$instance['appear-on-scroll'];
		
		$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-b-appear-effect','fade'):$instance['appear-effect'];
		
		$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-b-appear-from','left'):$instance['appear-from'];
		
		$bg_image = empty($instance['bg-image']) ? get_theme_mod('bw-b-bg-image'):$instance['bg-image'];
		
		$bg_color = empty($instance['bg-color']) ? get_theme_mod('bw-b-bg-color','#ffffff'):$instance['bg-color'];
		
		$txt_color = empty($instance['txt-color']) ? get_theme_mod('bw-b-txt-color','#000000'):$instance['txt-color'];
		
		$bg_image_size = empty($instance['bg-image-size']) ? get_theme_mod('bw-b-bg-size','auto'):$instance['bg-image-size'];
		
		$bg_image_position = empty($instance['bg-image-position']) ? get_theme_mod('bw-b-bg-pos','center'):$instance['bg-image-position'];
		
		$bg_opacity = empty($instance['bg-opacity']) ? get_theme_mod('bw-b-bg-opacity',100):intval($instance['bg-opacity']);
		
		//Parallox Effect.
		$scroll_effect = empty($instance['scroll-effect']) ? get_theme_mod('bw-b-bg-atta',false):$instance['scroll-effect'];
		?>
		
		<table class = 'form-table'>
		<!-- Title -->
		<tr>
			<td>
				<label for = '<?php echo $this->get_field_id('head'); ?>'>
					<?php _e("Title",'bw'); ?>
				</label>
			</td>
			<td>
				<input
					type = 'text'
					name = '<?php echo $this->get_field_name('head'); ?>'
					id = "<?php echo $this->get_field_id("head"); ?>"
					value = "<?php echo $head; ?>" />
			</td>
		</tr>
		<!-- Content -->
		<tr>
			<?php $contents = get_posts(array('post_type' => 'content','numberposts' => -1)); ?>
			<td>
				<label style = 'display:block;' for = '<?php echo $this->get_field_id('content'); ?>'>
					<?php _e("Content",'bw'); ?>
				</label>
			</td>
			<td>
				<select
					name = '<?php echo $this->get_field_name('content'); ?>'
					id = '<?php echo $this->get_field_id('content'); ?>'>
					
					<option value = ''>None</option>
					
					<?php foreach($contents as $con): ?>
					
						<?php if( $con->post_status == 'publish' ): ?>
							<option <?php selected($content,$con->ID);?> value = '<?php echo $con->ID; ?>'>
								<?php echo $con->post_title; ?>
							</option>
						<?php endif; ?>
					
					<?php endforeach; ?>
					
				</select>
			</td>
		</tr>
		
		<!-- Tag Id -->
		<tr>
			<td>
				<label style = 'display:block' for = "<?php echo $this->get_field_id('tag-id'); ?>">
					<?php _e("Tag ID",'bw'); ?>
				</label>
			</td>
			<td>
				<input
					type  = 'text'
					name  = '<?php echo $this->get_field_name("tag-id"); ?>'
					id	  = '<?php echo $this->get_field_id("tag-id"); ?>'
					value = '<?php echo $tag_id; ?>'/>
			</td>
		</tr>
	
		<!-- Appear On Scroll Effect -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id("appear-on-scroll");?>">
					<?php _e("Appear On Scroll",'bw');?>
				</label>
			</td>
			<td>
				<input
					type = 'checkbox'
					name = '<?php echo $this->get_field_name("appear-on-scroll"); ?>'
					id = "<?php echo $this->get_field_id('appear-on-scroll'); ?>" 
					<?php checked($appear_on_scroll,true);?>/>
			</td>
		</tr>
	</table>
	
	<details style = 'margin:10px 0;padding:10px;background:#eee;'>
		<summary><?php _e("Appear Options",'bw');?></summary>
		
		<table class = 'form-table'> 
			<!-- Appear Effect -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id("appear-effect"); ?>">
						<?php _e("Appear Effect",'bw');?>
					</label>
				</td>
				<td>
					<select
							name = '<?php echo $this->get_field_name("appear-effect");?>'
							id = '<?php echo $this->get_field_id("appear-effect");?>'>
					
						<option value = 'fade' <?php selected($appear_effect,'fade');?>><?php _e("Fade",'bw');?></option>
						<option value = 'slide' <?php selected($appear_effect,'slide');?>><?php _e("Slide",'bw');?></option>
						<option value = 'flip' <?php selected($appear_effect,'flip');?>><?php _e("Flip",'bw');?></option>
					
					</select>
				</td>
			</tr>
			<!-- Appear From ? -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('appear-from');?>">
						<?php _e("Appear From",'bw');?>
					</label>
				</td>
				<td>
					<select
							name = '<?php echo $this->get_field_name("appear-from");?>'
							id = '<?php echo $this->get_field_id("appear-from");?>'>
						<option value = 'top' <?php selected($appear_from,'top');?>><?php _e("Top",'bw'); ?></option>
						<option value = 'left' <?php selected($appear_from,'left');?>><?php _e("Left",'bw'); ?></option>
						<option value = 'bottom' <?php selected($appear_from,'bottom');?>><?php _e("Bottom",'bw'); ?></option>
						<option value = 'right' <?php selected($appear_from,'right');?>><?php _e("Right",'bw'); ?></option>
					</select>
				</td>
			</tr>
		</table>
	</details>
	
	<details style = 'padding:10px;background:#EEE;'>
	
		<summary><?php _e("Background",'bw');?></summary>
	
		<table class = 'form-table'>
		
		<!-- Background Image -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id("bg-image"); ?>">
					<?php _e("Background Image",'bw'); ?>
				</label>
			</td>
			<td>
				<img
					src = '<?php echo wp_get_attachment_url($bg_image); ?>'
					class = 'section_img' 
					style = 'max-width:100%;padding-top:5px;'/>
				<input
					type = 'hidden'
					name = '<?php echo $this->get_field_name("bg-image"); ?>'
					id = '<?php echo $this->get_field_id("bg-image"); ?>'
					value = '<?php echo $bg_image; ?>'
					class = 'section_id' />
				<button
					style = 'position:relative;'
					type = 'button'
					id = 'section'
					class = 'button custom_media_upload'>
					<?php _e("Upload/Change Image",'bw'); ?>
					<input 	
						type = 'checkbox'
						style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'/>
				</button>
				<?php if( !empty($bg_image) ):?>
				<button
					type = 'button'
					class = 'button remove'
					style = 'position:relative'
					id = 'section'>
					<?php _e("Remove Image",'bw');?>
					<input 	
						type = 'checkbox'
						style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'
						id = "section_check"/>
				</button>
				<?php endif;?>
			</td>
		</tr>
	
		<!-- Image Size -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id('bg-image-size'); ?>">
					<?php _e("Image Size",'bw'); ?>
				</label>
			</td>
			<td>
				<select
					id = '<?php echo $this->get_field_id("bg-image-size"); ?>'
					name = "<?php echo $this->get_field_name('bg-image-size'); ?>">
					
					<option value = 'cover' <?php selected($bg_image_size,'cover'); ?>><?php _e("Cover",'bw'); ?></option>
					<option value = 'contain' <?php selected($bg_image_size,'contain'); ?>><?php _e("Contain",'bw'); ?></option>
					<option value = '100% 100%' <?php selected($bg_image_size,'100% 100%'); ?>><?php _e("Fit",'bw'); ?></option>
					
				</select>
			</td>
		</tr>
		
		<!-- Image Position -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id("bg-image-position"); ?>">
					<?php _e("Background Position",'bw'); ?>
				</label>
			</td>
			<td>
			<?php bwbw_bg_position(
				$this->get_field_id('bg-image-position'),
				$this->get_field_name('bg-image-position')
			);?>
			</td>
		</tr>
		
		<!-- Text Color -->
		<tr>
			<td>
				<label for = '<?php echo $this->get_field_id('txt-color'); ?>'>
					<?php _e("Text Color",'bw');?>
				</label>
			</td>
			<td>
			<?php bwbw_color_picker(
				$this->get_field_id('txt-color'),
				$this->get_field_name('txt-color'),
				$txt_color); ?>
			</td>
		</tr>
		
		<!-- Background Color -->
		<tr>
			<td>
				<label for = '<?php echo $this->get_field_id("bg-color"); ?>'>
					<?php _e("Background Color",'bw'); ?>
				</label>
			</td>
			<td>
			<?php bwbw_color_picker(
				$this->get_field_id('bg-color'),
				$this->get_field_name('bg-color'),
				$bg_color
			);?>
			</td>
		</tr>
		
		<!-- Background Opacity -->
		<tr>
			<td>
				<label for = '<?php echo $this->get_field_id('bg-opacity'); ?>'>
					<?php _e("Opacity ". $bg_opacity,'bw'); ?>%
				</label>
			</td>
			<td>
				<input
					type = 'range'
					id = '<?php echo $this->get_field_id("bg-opacity"); ?>'
					name = "<?php echo $this->get_field_name('bg-opacity'); ?>"
					value = '<?php echo $bg_opacity; ?>'
					min = '0'
					max = '100'
					step = '10' />
			</td>
		</tr>
	
		<!-- Scroll Effect -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id('scroll-effect'); ?>">
					<?php _e("Scrolling Effect",'bw'); ?>
				</label>
			</td>
			<td>
				<input
					type = 'checkbox'
					name = '<?php echo $this->get_field_name('scroll-effect'); ?>'
					id = '<?php echo $this->get_field_id('scroll-effect'); ?>'
					<?php checked($scroll_effect); ?> />
			</td>
		</tr>
	</table>
		<?php
	}
	
	function widget ($args,$instance) {
	
		$style = "";
		$layout_style = "";
		$inner_style = "";
		
		$tag_id = empty($instance['tag-id']) ? '':$instance['tag-id'];
		
		//Layout Styling.
		$bg_color = empty($instance['bg-color']) ? get_theme_mod('bw-b-bg-color','#fff'):$instance['bg-color'];
		$layout_style .= "background-color:". $bg_color .";";
		
		$bg_opacity = empty($instance['bg-opacity']) ? get_theme_mod('bw-b-bg-opacity',100):$instance['bg-opacity'];
		$layout_style .= "opacity:". ($bg_opacity / 100) .";";
		
		//Section styling.
		$bg_image = empty($instance['bg-image']) ? get_theme_mod("bw-b-bg-image"):$instance['bg-image'];
		$style .= "background-image:url(". wp_get_attachment_image_src($bg_image,'large')[0] .");";
		
		$txt_color = empty($instance['txt-color']) ? get_theme_mod("bw-b-txt-color",'#000'):$instance['txt-color'];
		$inner_style = "color:". $txt_color .";";
		
		$img_size = empty($instance['bg-image-size']) ? get_theme_mod('bw-b-bg-size','auto'):$instance['bg-image-size'];
		$style .= "background-size:". $img_size .";";
		
		$img_pos = empty($instance['bg-image-position']) ? get_theme_mod('bw-b-bg-pos','center'):$instance['bg-image-position'];
		$style .= "background-position:". $img_pos .";";
		
		if( !empty($instance['bg-opacity'])
		&& get_theme_mod('bw-b-bg-atta',false) != false ) {
			
			$style .= "background-attachment:fixed;";
		}
		
		$appear = "";
		//Appear On Scroll Effect.
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-b-appear-on-scroll',false):$instance['appear-on-scroll'];
		if( $appear_on_scroll ) {
			
			$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-b-appear-effect','fade'):$instance['appear-effect'];
			$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-b-appear-from','left'):$instance['appear-from'];
			
			$appear = "appear-effect = '". $appear_effect ."' appear-from = '". $appear_from ."'";
		}?>
		
		<section 
			id = '<?php echo $tag_id;?>'
			<?php echo $appear;?>
			class = 'normal-section' 
			style = '<?php echo $style;?>'>
		
			<div class = 'layout' style = '<?php echo $layout_style;?>'></div>
		
			<div style = '<?php echo $inner_style;?>' class = 'inner'>
			
				<?php if( !empty($instance['head']) ):?>
					<h2 class = 'widget-head'>
						<?php _e($instance['head'],'es');?>
					</h2>
				<?php endif;
				
				$contentId = empty($instance['content']) ? 0:$instance['content'];
				$id = filter_var($contentId,FILTER_SANITIZE_NUMBER_INT);
				$content = get_post($id);
			
				if(isset($content) && $id != 0):?>
					
					<div class = 'section-inner-container'>
						<?php echo $content->post_content;?>
					</div>
				<?php endif;?>
			
			</div>
		
		</section>
	<?php
	}
	
	function update($new,$old) {
		
		$instance = $old;
		
		$instance['head'] = esc_html($new['head']);
		$instance['content'] = esc_url($new['content']);
		$instance['tag-id'] = esc_html($new['tag-id']);
		$instance['appear-on-scroll'] = rest_sanitize_boolean($new['appear-on-scroll']);
		$instance['appear-effect'] = esc_html($new['appear-effect']);
		$instance['appear-from'] = esc_html($new['appear-from']);
		$instance['bg-image'] = absint($new['bg-image']);
		$instance['bg-color'] = sanitize_hex_color($new['bg-color']);
		$instance['txt-color'] = sanitize_hex_color($new['txt-color']);
		$instance['bg-image-size'] = esc_html($new['bg-image-size']);
		$instance['bg-image-position'] = esc_html($new['bg-image-position']);
		$instance['bg-opacity'] = filter_var($new['bg-opacity'],FILTER_SANITIZE_NUMBER_FLOAT);
		$instance['scroll-effect'] = rest_sanitize_boolean($new['scroll-effect']);
		
		return $instance;
	}
}

register_widget("Normal_Section");

?>