<?php

class Grid_Section extends WP_Widget {
	
	function __construct () {
		parent::__construct(
			"grid_section",
			__("Grid Section",'bw'),
			array("classname" => "grid_section"));
	}
	
	function form ($instance) {
		
		//Section Title.
		$head = empty($instance['head']) ? '':$instance['head'];
		
		//Tag Id ( For Automatic Scroll Effect )
		$tag_id = empty($instance['tag-id']) ? '':$instance['tag-id'];
		
		//Number Of Grids To Show.
		$num_of_grids = empty($instance['num-of-grids']) ? 1:$instance['num-of-grids'];
		
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-g-appear-on-scroll',false):$instance['appear-on-scroll'];
		
		$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-g-appear-effect','fade'):$instance['appear-effect'];
		
		$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-g-appear-from','left'):$instance['appear-from'];
		
		//Grid's Option.
		for($i = 0;$i < $num_of_grids;$i++) {
			
			//Grid Title.
			$grids_option[$i]['head'] = empty($instance['grid-'. $i .'-head']) ? '':$instance['grid-'. $i .'-head'];
			
			//Grid Picture
			$grids_option[$i]['pic'] = empty($instance['grid-'. $i .'-pic']) ? '':$instance['grid-'. $i .'-pic'];
			
			//Grid Content
			$grids_option[$i]['content'] = empty($instance['grid-'. $i .'-content']) ? '':filter_var($instance['grid-'. $i .'-content'],FILTER_SANITIZE_NUMBER_INT);
			
			//Grid Background Color.
			$grids_option[$i]['bg-color'] = empty($instance['grid-'. $i .'-bg-color']) ? get_theme_mod('bg-g-grid-bg-color','#ffffff'):$instance['grid-'. $i .'-bg-color'];
			
			//Grid Text Color.
			$grids_option[$i]['txt-color'] = empty($instance['grid-'. $i .'-txt-color']) ? get_theme_mod('bg-g-grid-txt-color','#000000'):$instance['grid-'. $i .'-txt-color'];
		}
		
		//Section's Background Image		
		$bg_image = empty($instance['bg-image']) ? get_theme_mod('bw-g-bg-image',0):$instance['bg-image'];
		
		//Section's Background Color.
		$bg_color = empty($instance['bg-color']) ? get_theme_mod('bw-g-bg-color','#030a0f'):$instance['bg-color'];
	
		//Section's Text Color.
		$txt_color = empty($instance['txt-color']) ? get_theme_mod('bw-g-txt-color','#000000'):$instance['txt-color'];
		
		//Section's Background Size.
		$bg_image_size = empty($instance['bg-image-size']) ? get_theme_mod('bw-g-image-size','auto'):$instance['bg-image-size'];
		
		//Section's Background Position.
		$bg_image_position = empty($instance['bg-image-position']) ? get_theme_mod('bw-g-bg-pos','center'):$instance['bg-image-position'];
		
		//Section's Background Color Opacity.
		$opacity = empty($instance['opacity']) ? get_theme_mod('bw-g-bg-opacity',100):intval($instance['opacity']);
	
		//Section's Parallox Effect ( Boolean ).
		$scroll_effect = empty($instance['scroll-effect']) ? get_theme_mod('bw-g-scroll-effect',false):rest_sanitize_boolean($instance['scroll-effect']);
	
		//Section's Vertical Scroll ( Boolean ).
		$vertical_scroll = empty($instance['vertical-scroll']) ? get_theme_mod('bw-g-vertical-scroll',false):true;
	
		//Section's Grid Numbers Appear.
		$have_grid_numbers = empty($instance['have-grid-numbers']) ? false:$instance['have-grid-numbers'];
	
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
						name = '<?php echo $this->get_field_name("head"); ?>'
						id = '<?php echo $this->get_field_id('head'); ?>' 
						value = '<?php echo $head; ?>'/>
				</td>
			</tr>
		
			<!-- Tag Id -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('tag-id'); ?>">
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
					<label for = "<?php echo $this->get_field_id("appear-on-scroll"); ?>">
						<?php _e("Appear On Scroll",'bw'); ?>
					</label>
				</td>
				<td>
					<input
						type = 'checkbox'
						name = '<?php echo $this->get_field_name("appear-on-scroll"); ?>'
						id = "<?php echo $this->get_field_id('appear-on-scroll'); ?>" 
						<?php checked($appear_on_scroll); ?>/>
				</td>
			</tr>
		</table>
			
		<details style = 'padding:10px;margin:10px 0;background:#EEE;'>
		
			<summary><?php _e("Appear Options",'bw');?></summary>
		
			<table class = 'form-table'>
				<!-- Appear Effect -->
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id("appear-effect"); ?>">
							<?php _e("Appear Effect",'bw'); ?>
						</label>
					</td>
					<td>
						<select
								name = '<?php echo $this->get_field_name("appear-effect"); ?>'
								id = '<?php echo $this->get_field_id("appear-effect"); ?>'>
						
							<option value = 'fade' <?php selected($appear_effect,'fade'); ?>><?php _e("Fade",'bw');?></option>
							<option value = 'slide' <?php selected($appear_effect,'slide'); ?>><?php _e("Slide",'bw');?></option>
							<option value = 'flip' <?php selected($appear_effect,'flip'); ?>><?php _e("Flip",'bw');?></option>
						
						</select>
					</td>
				</tr>
		
				<!-- Appear From ? -->
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id('appear-from'); ?>">
							<?php _e("Appear From",'bw'); ?>
						</label>
					</td>
					<td>
						<?php $appearList = array('top','right','bottom','left');?>
						<select
							name = '<?php echo $this->get_field_name("appear-from"); ?>'
							id = '<?php echo $this->get_field_id("appear-from"); ?>'>
							<?php foreach($appearList as $appear):?>
							<option value = '<?php echo $appear;?>' <?php selected($appear,$appear_from);?>>
								<?php _e(ucfirst($appear),'bw');?>
							</option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
			</table>
		</details>
		
		<table class = 'form-table'>
		
			<!-- Number Of Grids -->
			<tr>
				<td>
					<label for = '<?php echo $this->get_field_id('num-of-grids'); ?>'>
						<?php _e("Number Of Grids",'bw'); ?>
					</label>
				</td>
				<td>
					<input
						type = 'number'
						min = '1'
						max = '15'
						id = '<?php echo $this->get_field_id('num-of-grids'); ?>'
						name = '<?php echo $this->get_field_name('num-of-grids'); ?>'
						value = '<?php echo $num_of_grids; ?>' />
				</td>
			</tr>
		</table>
		
		<?php 
		for($i = 0;$i < $num_of_grids;$i++): ?>
		
		<details style = 'padding:10px;margin:10px 0;background:#DDD;'>
		
			<summary><?php _e("Grid ". ($i + 1),'bw'); ?></summary>
			
			<table class = 'form-table'>
				<!-- Grid Title -->
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id('grid-'. $i .'-head'); ?>">
							<?php _e("Title",'bw'); ?>
						</label>
					</td>
					<td>
						<input
							type = 'text'
							name = "<?php echo $this->get_field_name('grid-'. $i .'-head'); ?>"
							id = "<?php echo $this->get_field_id('grid-'. $i .'-head'); ?>" 
							value = "<?php echo $grids_option[$i]['head']; ?>" />
					</td>
				</tr>
				<!-- Grid Picture -->
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id('grid-'. $i .'-pic'); ?>">
							<?php _e("Picture",'bw'); ?>
						</label>
					</td>
					<td>
						<img
							src = '<?php echo wp_get_attachment_url($grids_option[$i]['pic']);?>'
							class = 'grid-<?php echo $i; ?>_img'
							style = 'max-width:100%;padding-top:10px;' />
						<input
							type = 'hidden'
							class = 'grid-<?php echo $i; ?>_id'
							id = '<?php echo $this->get_field_id("grid-". $i ."-pic"); ?>'
							name = '<?php echo $this->get_field_name("grid-". $i ."-pic"); ?>' 
							value = "<?php echo $grids_option[$i]['pic']; ?>"/>
						<button
							type  = 'button'
							class = 'button custom_media_upload'
							id	  = 'grid-<?php echo $i; ?>'
							style = 'position:relative;'>
							<?php _e("Upload/Change Image",'bw');?>
							<input 	
								type = 'checkbox'
								style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'/>		
						</button>
						<?php if( !empty($bg_image) ):?>
						<button
							type = 'button'
							class = 'button remove'
							style = 'position:relative'
							id = 'grid-<?php echo $i;?>'>
							<?php _e("Remove Image",'bw');?>
							<input 	
								type = 'checkbox'
								style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'
								id = "section_check"/>
						</button>
						<?php endif;?>
					</td>
				</tr>
				
				<!-- Content -->
				<?php $contents = get_posts(array('post_type' => 'content','numberposts' => -1)); ?>
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id('grid-'. $i .'-content'); ?>">
							<?php _e("Content",'bw'); ?>
						</label>
					</td>
					<td>
						<select
							id = '<?php echo $this->get_field_id('grid-'. $i .'-content'); ?>' 
							name = '<?php echo $this->get_field_name('grid-'. $i .'-content'); ?>'>
							
							<option value = ''><?php _e("None",'bw');?></option>
							
							<?php foreach($contents as $con): ?>
							
								<?php if( $con->post_status == 'publish' ): ?>
									<option <?php selected($grids_option[$i]['content'],absint($con->ID));?> value = '<?php echo absint($con->ID); ?>'>
										<?php echo esc_html($con->post_title); ?>
									</option>
								<?php endif; ?>
							
							<?php endforeach; ?>
					
						</select>
					</td>
				</tr>
				
				<!-- Grid Background Color -->
				<tr>
					<td>
						<label for = '<?php echo $this->get_field_id("grid-". $i ."-bg-color"); ?>'>
							<?php _e("Background Color",'bw'); ?>
						</label>
					</td>
					<td>
					<?php bwbw_color_picker(
						$this->get_field_id('grid-'. $i .'-bg-color'),
						$this->get_field_name('grid-'. $i .'-bg-color'),
						$grids_option[$i]['bg-color']);?>
					</td>
				</tr>
			
				<!-- Grid Text Color -->
				<tr>
					<td>
						<label for = "<?php echo $this->get_field_id("grid-".$i."-txt-color"); ?>">
							<?php _e("Text Color",'bw'); ?>
						</label>
					</td>
					<td>
					<?php bwbw_color_picker(
						$this->get_field_id('grid-'. $i .'-txt-color'),
						$this->get_field_name('grid-'. $i .'-txt-color'),
						$grids_option[$i]['txt-color']); ?>
					</td>
				</tr>
			</table>
		
		</details>
		
		<?php endfor; ?>
		
		<details style = 'background:#DDD;padding:10px;'>
		
			<summary>
				<?php _e("Background",'bw');?>
			</summary>
		
			<table class = 'form-table'>
			
			<!-- Background Color -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('bg-color'); ?>">
						<?php _e("Background Color",'bw'); ?>
					</label>
				</td>
				<td>
				<?php bwbw_color_picker(
					$this->get_field_id('bg-color'),
					$this->get_field_name('bg-color'),
					$bg_color);?>
				</td>
			</tr>
			
			<!-- Opacity -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('opacity'); ?>">
						<?php _e("Background Opacity ".$opacity,'bw'); ?>%
					</label>
				</td>
				<td>
					<input
						type = 'range'
						class = 'range'
						id = '<?php echo $this->get_field_id("opacity"); ?>'
						name = '<?php echo $this->get_field_name("opacity"); ?>'
						min = "0"
						max = "100"
						step = "10" 
						value = "<?php echo $opacity; ?>" />
				</td>
			</tr>
			
			<!-- Background Image -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('bg-image'); ?>">
						<?php _e("Background Image",'bw'); ?>
					</label>
				</td>
				<td>
					<img
						src = '<?php echo $bg_image; ?>' 
						class = 'bg-image_img'
						style = 'max-width:100%;padding-top:10px;'/>
					<input
						type = 'hidden'
						id = '<?php echo $this->get_field_id("bg-image"); ?>'
						name = '<?php echo $this->get_field_name("bg-image"); ?>' 
						value = "<?php echo $bg_image; ?>"
						class = 'bg-image_id'/>
					<button
						type = 'button'
						id = 'bg-image'
						class = 'button custom_media_upload'
						style = 'position:relative;'>
						<?php _e("Upload/Change Image",'bw'); ?>
							<input 	
								type = 'checkbox'
								style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'/>
					</button>
				</td>
			</tr>
		
			<!-- Background Size -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('bg-image-size'); ?>">
						<?php _e("Background Size",'bw'); ?>
					</label>
				</td>
				<td>
					<select
						name = '<?php echo $this->get_field_name('bg-image-size'); ?>'
						id = '<?php echo $this->get_field_id('bg-image-size'); ?>'>
						
						<option value = 'cover' <?php selected($bg_image_size,'cover'); ?>><?php _e("Cover",'bw'); ?></option>
						<option value = 'contain' <?php selected($bg_image_size,'contain'); ?>><?php _e("Contain",'bw'); ?></option>
						<option value = '100% 100%' <?php selected($bg_image_size,'100% 100%'); ?>><?php _e("Fit",'bw'); ?></option>
						
					</select>
				</td>
			</tr>
			
			<!-- Background Position -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id("bg-image-position"); ?>">
						<?php _e("Background Position",'bw'); ?>
					</label>
				</td>
				<td>
				<?php bwbw_bg_position(
				$this->get_field_id('bg-image-position'),
				$this->get_field_name('bg-image-position'));?>
				</td>
			</tr>
			
		</details>
	
		<!-- Scrolling Effect -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id("scroll-effect"); ?>">
					<?php _e("Scroll Effect",'bw'); ?>
				</label>
			</td>
			<td>
				<input
					type = 'checkbox'
					name = "<?php echo $this->get_field_name("scroll-effect"); ?>"
					id = "<?php echo $this->get_field_id("scroll-effect"); ?>"
					<?php checked($scroll_effect); ?>/>
			</td>
		</tr>
		
		<!-- Vertical Scrolling -->
		<tr>
			<td>
				<label for = "<?php echo $this->get_field_id("vertical-scroll"); ?>">
					<?php _e("Vertical Scroll",'bw'); ?>
				</label>
			</td>
			<td>
				<input
					type = 'checkbox'
					name = "<?php echo $this->get_field_name("vertical-scroll"); ?>"
					id = "<?php echo $this->get_field_id("vertical-scroll"); ?>"
					<?php checked($vertical_scroll); ?>/>
			</td>
		</tr>
		
		<!-- Have Grid Numbers -->
		<tr>
			<td>
				<label for = '<?php echo $this->get_field_id('have-grid-numbers');?>'>
					<?php _e("Have Grid Numbers ?",'bw');?>
				</label>
			</td>
			<td>
				<input
					type = 'checkbox'
					name = '<?php echo $this->get_field_name('have-grid-numbers');?>'
					id = '<?php echo $this->get_field_id('have-grid-numbers');?>'
					<?php checked($have_grid_numbers,true);?> />
			</td>
		</tr>
	</table>
		<?php
	}
	
	function widget ($args,$instance) {
		
		$layout_style = "";
		$style = "";
		
		//Grid Numbers.
		$grid_numbers = empty($instance['have-grid-numbers']) ? false:$instance['have-grid-numbers'];
		
		if( $grid_numbers == true ) {
			
			$style .= "padding-bottom:40px;";
		}
		
		//Layout Styling.
		$bg_opacity = empty($instance['opacity']) ? get_theme_mod('bw-g-bg-opacity',100):$instance['opacity'];
		$layout_style .= "opacity:". ($bg_opacity / 100 ) .";";
	
		$bg_color = empty($instance['bg-color']) ? get_theme_mod('bw-g-bg-color','#ffffff'):$instance['bg-color'];
		$layout_style .= "background-color:". $bg_color .";";
		
		//Main Section Styling.
		$bg_image = empty($instance['bg-image']) ? get_theme_mod('bw-g-bg-image'):$instance['bg-image'];
		$style .= "background-image:url(". wp_get_attachment_image_src($bg_image,'large')[0] .");";
		
		if( !empty($instance['scroll-effect']) 
		&& get_theme_mod('bw-g-scroll-effect',false) != false ) {
			
			$style .= "background-attachment:fixed;";
		}
		
		$has_vertical_scroll = empty($instance['vertical-scroll']) ? get_theme_mod('bw-g-vertical-scroll',false):$instance['vertical-scroll'];
		if( $has_vertical_scroll && $instance['vertical-scroll'] == true ) {
			
			$vertical_scroll = "flex-wrap:nowrap;height:auto;";
		}else {
			
			$vertical_scroll = "flex-wrap:wrap;max-width:100%;";
		}
		
		$size = empty($instance['bg-image-size']) ? get_theme_mod('bw-g-bg-size','auto'):$instance['bg-image-size'];
		$style .= "background-size:". $size .";";
		
		$position = empty($instance['bg-image-position']) ? get_theme_mod('bw-g-bg-pos','center'):$instance['bg-image-position'];
		$style .= "background-position:". $position .";";
	
		$tag_id = empty($instance['tag-id']) ? '':$instance['tag-id'];
	
		$n = empty($instance['num-of-grids']) ? 1:$instance['num-of-grids'];
	
		$appear = "";
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-g-appear-on-scroll',false):$instance['appear-on-scroll'];
		//Appear On Scroll Effect.
		if($appear_on_scroll) {
			
			$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-g-appear-effect','fade'):$instance['appear-effect'];
			$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-g-appear-from','left'):$instance['appear-from'];
			
			$appear = "appear-effect = '". $appear_effect ."' appear-from = '". $appear_from ."'";
			
		}?>
	
		<section 
			id = '<?php echo $tag_id;?>' 
			<?php echo $appear;?> 
			class = 'grid-section' 
			style = '<?php echo $style;?>'>
			
			<?php if( !empty($instance['head']) ):?>
			<h2 class = 'widget-head'>
				<?php _e($instance['head'],'es');?>
			</h2>
			<?php endif;?>
			
			<div 
				class = 'layout' 
				style = '<?php echo $layout_style;?>'></div>
			
			<?php if( $has_vertical_scroll ): $lang_dir = is_rtl() ? array('right','left'):array('left','right');?>
				
				<button	
					id = 'grid-move-left'
					class = 'requireJs grid-move'
					title = '<?php _e("Previous Grid Items",'bw');?>'>
					
					<i class = 'fas fa-angle-<?php echo $lang_dir[0];?> fa-2x'></i>
				</button>
						
				<?php if( $grid_numbers == true ):?>
					<section class = 'grid-numbers'></section>
				<?php endif;?>
					
				<button
					id = 'grid-move-right' 
					class = 'requireJs grid-move'
					title = '<?php _e("Next Grid Items",'bw');?>'>

					<i class = 'fas fa-angle-<?php echo $lang_dir[1];?> fa-2x'></i>
				</button>
				
			<?php endif;?>

			<section 
				class = 'main-grid' 
				vertical-scroll = '<?php echo $has_vertical_scroll == true ? 1:0;?>' 
				num-of-grids='<?php echo $n;?>' 
				style = '<?php echo $vertical_scroll;?>'>
			
				<?php for($i = 0;$i < $n;$i++):
					
					$container_style = "";
					
					$container_bg_color = empty($instance['grid-'. $i .'-bg-color']) ? get_theme_mod('bw-g-grid-bg-color','#ffffff'):$instance['grid-'. $i .'-bg-color'];
					$container_style .= "background-color:". $container_bg_color .";";
					
					$container_txt_color = empty($instance['grid-'. $i .'-txt-color']) ? get_theme_mod('bw-g-grid-txt-color','#000000'):$instance['grid-'. $i .'-txt-color'];
					$container_style .= "color:". $container_txt_color .";";
					?>
					
					<div class = 'container' style = '<?php echo $container_style;?>'>
						<h3>
							<?php echo empty($instance['grid-'. $i .'-head']) ? '':$instance['grid-'.$i.'-head'];?>
						</h3>
					
						<?php echo empty($instance['grid-'.$i.'-pic']) ? '':wp_get_attachment_image($instance['grid-'.$i.'-pic'],'thumbnail');?>
						
						<?php
					
					$grid_content = empty($instance['grid-'.$i.'-content']) ? 0:$instance['grid-'. $i .'-content'];
					$id = absint($grid_content);
					$content = get_post($id);
					
					if($content != null && $id != 0) {
					
						echo $content->post_content;
					} ?>
					
					</div>
					
				<?php endfor;?>
		
			</section>
			
		</section>
	<?php
	}
	
	function update ($new,$old) {
		
		$instance = $old;
		
		$instance['head'] = esc_html($new['head']);
		$instance['tag-id'] = esc_html($new['tag-id']);
		$instance['num-of-grids'] = absint($new['num-of-grids']);
		$instance['appear-on-scroll'] = rest_sanitize_boolean($new['appear-on-scroll']);
		$instance['appear-effect'] = esc_html($new['appear-effect']);
		$instance['appear-from'] = esc_html($new['appear-from']);
		
		$n = $instance['num-of-grids'];
		for($i=0;$i<$n;$i++) {
			
			$instance['grid-'. $i .'-head'] = esc_html($new['grid-'. $i .'-head']);
			$instance['grid-'. $i .'-pic'] = absint($new['grid-'. $i .'-pic']);
			$instance['grid-'. $i .'-content'] = absint($new['grid-'. $i .'-content']);
			$instance['grid-'. $i .'-bg-color'] = sanitize_hex_color($new['grid-'. $i .'-bg-color']);
			$instance['grid-'. $i .'-txt-color'] = sanitize_hex_color($new['grid-'. $i .'-txt-color']);
		}
		
		$instance['bg-image'] = absint($new['bg-image']);
		$instance['bg-color'] = sanitize_hex_color($new['bg-color']);
		$instance['txt-color'] = sanitize_hex_color($new['txt-color']);
		$instance['bg-image-position'] = esc_html($new['bg-image-position']);
		$instance['bg-image-size'] = esc_html($new['bg-image-size']);
		$instance['opacity'] = absint($new['opacity']);
		$instance['scroll-effect'] = rest_sanitize_boolean($new['scroll-effect']);
		$instance['vertical-scroll'] = rest_sanitize_boolean($new['vertical-scroll']);
		$instance['have-grid-numbers'] = rest_sanitize_boolean($new['have-grid-numbers']);
		
		return $instance;
	}
}

register_widget("Grid_Section");
?>