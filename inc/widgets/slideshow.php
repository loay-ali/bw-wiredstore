<?php
class se_slideshow_widget extends WP_Widget {
	
	function __construct () {
		
		$args = array(
			"classname" => "se_slideshow_widget",
			"description" => __("Display Pictures With Caption In a Slideshow",'bw'));
		
		parent::__construct("se_slideshow_widget","Slideshow Widget",$args);
	}
	
	function form ($instance) {
	
		$num_of_slides = empty($instance['num-of-slides']) ? 1:$instance['num-of-slides'];
		
		$slide_progress = !isset($instance['slide-progress']) ? true:$instance['slide-progress'];
		
		$tag_id = empty($instance['tag-id']) ? '':$instance['tag-id'];
		
		$slide_effect = empty($instance['slide-effect']) ? 'none':$instance['slide-effect'];
		
		$slides_option = array();
		
		for($i = 0;$i < $num_of_slides;$i++) {
			
			//Slide Background Image.
			$slides_option[$i]['bg-image'] = empty($instance['bg-image-' . $i]) ? 0:$instance['bg-image-' . $i];
			
			//Slide Caption.
			$slides_option[$i]['caption'] = empty($instance['caption-' . $i]) ? '':$instance['caption-' . $i];	
		} ?>
		
		<table class = 'form-table'>
			<!-- Number Of Slides -->
			<tr>
				<td>
					<label for = '<?php echo $this->get_field_id("num-of-slides"); ?>'>
						<?php _e("Number Of Slides",'bw'); ?>
					</label>
				</td>
				<td>
					<input
						type = 'number'
						id = '<?php echo $this->get_field_id('num-of-slides'); ?>'
						value = "<?php echo $num_of_slides; ?>"
						name = '<?php echo $this->get_field_name('num-of-slides'); ?>' />
				</td>
			</tr>
			<!-- Slide Effect -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('scroll-effect');?>">
						<?php _e("Slide Effect",'bw'); ?>
					</label>
				</td>
				<td>
					<?php $effectList = array('none','slide','fade','zoom','flip');?>
					<select
						name = '<?php echo $this->get_field_name("slide-effect"); ?>'
						id = '<?php echo $this->get_field_id("slide-effect"); ?>'>
						<?php foreach($effectList as $effect):?>
						<option value = '<?php echo $effect;?>' <?php selected($effect,$slide_effect);?>>
							<?php _e(ucfirst($effect),'bw');?>
						</option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
		
			<!-- Automatically Move Slides -->
			<tr>
				<td>
					<label for = '<?php echo $this->get_field_id('slide-progress');?>'>
						<?php _e("Automatically Change Slides",'bw');?>
					</label>
				</td>
				<td>
					<input
						type 	= 'checkbox'
						name 	= '<?php echo $this->get_field_name('slide-progress');?>'
						id  	= '<?php echo $this->get_field_id('slide-progress');?>'
						<?php checked($slide_progress,true);?> />
				</td>
			</tr>
		
			<!-- Tag Id -->
			<tr>
				<td>
					<label for = "<?php echo $this->get_field_id('tag-id'); ?>">
						<?php _e("Tag ID",'bw');?>
					</label>
				</td>
				<td>
					<input
						type  = 'text'
						name  = '<?php echo $this->get_field_name("tag-id");?>'
						id	  = '<?php echo $this->get_field_id("tag-id");?>'
						value = '<?php echo $tag_id; ?>'/>
				</td>
			</tr>
		</table>
		
		<?php for($i = 0;$i < $num_of_slides;$i++):?>
			
			<details style = 'padding:10px;margin:10px 0;background:#DDD;'>
				<summary><?php _e("Slide ".($i + 1),'bw');?></summary>
				
				<table class = 'form-table'>
					<!-- Caption -->
					<?php $contents = get_posts(array('post_type' => 'content','numberposts' => -1)); ?>
					<tr>
						<td>
							<label for = "<?php echo $this->get_field_id('caption-' . $i); ?>">
								<?php _e("Caption",'bw'); ?>
							</label>
						</td>
						<td>
							<select
								name = '<?php echo $this->get_field_name('caption-' . $i); ?>'
								id = '<?php echo $this->get_field_id('caption-' . $i); ?>'>
								
								<option value = ''><?php _e("None",'bw');?></option>
				
								<?php foreach($contents as $con): ?>
									
									<?php if( $con->post_status == 'publish' ): ?>
										<option <?php selected($slides_option[$i]['caption'],absint($con->ID)); ?> value = '<?php echo absint($con->ID); ?>'>
											<?php echo esc_html($con->post_title); ?>
										</option>
									<?php endif; ?>
								
								<?php endforeach; ?>
								
							</select>
						</td>
					</tr>
				
					<!-- Background Image -->
					<tr>
						<td>
							<label for = "<?php echo $this->get_field_id('bg-image-' . $i); ?>">
								<?php _e("Background Image",'bw'); ?>
							</label>
						</td>
						<td>
							<img
								src = "<?php echo wp_get_attachment_image_src($slides_option[$i]['bg-image'],'thumbnail')[0]; ?>"
								class = "slide_<?php echo $i; ?>_img" 
								style = 'max-width:100%;' />
							<input
								type = "hidden"
								value = "<?php echo $slides_option[$i]['bg-image']; ?>"
								id = "<?php echo $this->get_field_id('bg-image-' . $i); ?>"
								name = "<?php echo $this->get_field_name('bg-image-' . $i); ?>"
								class = 'slide_<?php echo $i;?>_id'/>
							<button 
								type  = 'button' 
								style = 'position:relative;'
								class = 'button custom_media_upload'
								id	  = 'slide_<?php echo $i; ?>'>
								<?php _e("Upload/Change Image",'bw'); ?>
								<input 	
									type = 'checkbox'
									style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'/>
							</button>
							<button
							class = 'button remove'
							type = 'button' style = 'position:relative;'
							id = 'slide_<?php echo $i;?>'><?php _e("Remove",'bw'); ?>
								<input 	
									type = 'checkbox'
									style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'
									id = "slide_<?php echo $i;?>_check"/></button>
						</td>
					</tr>
				</table>
			</details>
			<?php
		endfor;
		
	}
	
	function widget($args,$instance) {
		
		$num_of_slides = empty($instance['num-of-slides']) ? 1:abs(intval($instance['num-of-slides']));
		
		$slide_progress = !isset($instance['slide-progress']) ? true:$instance['slide-progress'];
		
		$tag_id = empty($instance['tag-id']) ? '':esc_html($instance['tag-id']);
		
		$effect = empty($instance['slide-effect']) ? 'none':esc_html($instance['slide-effect']);
		?>
		
		<section 
			id = '<?php echo $tag_id;?>' 
			class = 'slideshow'
			num-of-slides = '<?php echo $num_of_slides;?>'>
		
			<section
				id = 'main-slide' 
				effect = '<?php echo $effect;?>' 
				style = 'width:<?php echo $num_of_slides * 100 ?>%;'>
		
			<?php for($i = 0;$i < $num_of_slides;$i++):?>
				
				<div id = 'slide-<?php echo $i;?>'>
				
					<?php echo wp_get_attachment_image($instance['bg-image-'. $i],'large');?>
					
					<?php
					$id = filter_var($instance['caption-'.$i],FILTER_SANITIZE_NUMBER_INT);
					$content = get_post($id);
					
					if($content != null && $id != 0) {
					
						$con = $content->post_content;
					}else { $con = ""; }
					
					?>
						<section class = 'caption'>
							<?php echo($con); ?>
						</section>
				
				</div>
				
			<?php endfor;?>

			</section>
			
			<?php if($slide_progress == true):?>
				<!-- Pause Button -->
				<button class = 'requireJs' id = 'pause-slide' title = '<?php _e("Pause Slideshow",'bw');?>'>
					<i class = 'bwi bwi-pause'></i>
				</button>
			<?php endif;?>
			
			<?php $lang_dir = is_rtl() ? array('right','left'):array('left','right');?>
			<!-- Right & Left Arrows -->
			<button
				id = 'slide-move-left' 
				class = 'requireJs screen-only' 
				title = '<?php _e("Previous Slide",'bw');?>'>
				<i class = 'bwi bwi-arrow-<?php echo $lang_dir[0];?>'></i>
			</button>
		
			<button 
				id = 'slide-move-right' 
				class = 'requireJs screen-only'
				title = '<?php _e("Next Slide",'bw');?>'>
				<i class = 'bwi bwi-arrow-<?php echo $lang_dir[1];?>'></i>
			</button>

			<!-- Slide Number Buttons -->
			<div id = 'num-of-slides' class = 'screen-only requireJs'>

				<?php for($i = 1;$i <= $num_of_slides;$i++):?>
					<button title = '<?php _e("Slide Number ".$i,'bw');?>' <?php echo (($i == 1) ? 'id = "active"':'')?>>
						<?php echo $i;?>
					</button>
				<?php endfor; ?>

			</div>
			
			<!-- Progress Bar -->
			<div id = 'progress-bar' class = 'requireJs <?php echo $slide_progress == false ? 'no-move':''; ?>'></div>

		</section>
		
		<?php
	}
	
	function update ($new,$old) {
		
		$instance = $old;
		
		$instance['num-of-slides'] = absint($new['num-of-slides']);
		$instance['slide-progress'] = rest_sanitize_boolean($new['slide-progress']);
		$instance['tag-id'] = esc_html($new['tag-id']);
		$instance['slide-effect'] = esc_html($new['slide-effect']);
		
		$n = $instance['num-of-slides'];
		for($i=0;$i<$n;$i++) {
			
			$instance['bg-image-'. $i] = absint($new['bg-image-'. $i]);
			$instance['caption-'. $i] = absint($new['caption-'. $i]);
		}
		
		return $instance;	
	}
}

//Register Some Files For Uploading Images.
add_action("admin_enqueue_scripts",function(){
	wp_enqueue_media();
	wp_enqueue_script("media_uploader",get_template_directory_uri() . "/js/media_uploader.js",array('jquery'),false,true);
});

register_widget("se_slideshow_widget");

?>