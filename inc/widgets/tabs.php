<?php

class se_tabs_widget extends WP_Widget {
	

	function __construct() {
		
		parent::__construct('se_tabs_widget','Tabs Widgets',array(
		
			'classname' 	=> 'se_tabs_widget',
			'description'	=> __("Display Your Content In Tabs",'bw')
		));
	}
	
	function form($instance) {
		
		$title = empty($instance['title']) ? '':$instance['title'];
		$tagId = empty($instance['tag-id']) ? '':$instance['tag-id'];
		$num_of_tabs = empty($instance['num-of-tabs']) ? 1:$instance['num-of-tabs'];
		
		$tabs = array();
		
		for($i = 0;$i < $num_of_tabs;$i++) {
			
			$tabs[$i]['title'] = empty($instance['tab-'.$i.'-title']) ? ( $i + 1 ):$instance['tab-'.$i.'-title'];
			$tabs[$i]['content'] = empty($instance['tab-'.$i.'-content']) ? '':$instance['tab-'.$i.'-content'];
		}
		
		$bg = array();
		
		$bg['color'] = empty($instance['back-color']) ? get_theme_mod('bw-t-bg-color','#ffffff'):$instance['back-color'];
		$bg['image'] = empty($instance['back-image']) ? get_theme_mod('bw-t-bg-image'):$instance['back-image'];
		$bg['opacity'] = empty($instance['back-opacity']) ? get_theme_mod('bw-t-bg-opacity',100):$instance['back-opacity'];
		$bg['position'] = empty($instance['back-position']) ? get_theme_mod('bw-t-bg-pos','center'):$instance['back-position'];
		$bg['size'] = empty($instance['back-size']) ? get_theme_mod('bw-t-bg-size','auto'):$instance['back-size'];
		$bg['scroll-effect'] = empty($instance['scroll-effect']) ? get_theme_mod('bw-t-scroll-effect',false):$instance['scroll-effect'];
	
		$color = empty($instance['color']) ? get_theme_mod('bw-t-txt-color','#000000'):$instance['color'];
		
		$switchEffect = empty($instance['switch-effect']) ? get_theme_mod('bw-t-switch-effect','none'):$instance['switch-effect'];
		
		$appearOnScroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-t-appear-on-scroll',false):$instance['appear-on-scroll'];
		$appearEffect = empty($instance['appear-effect']) ? get_theme_mod('bw-t-appear-effect','fade'):$instance['appear-effect'];
		$appearFrom = empty($instance['appear-from']) ? get_theme_mod('bw-t-appear-from','left'):$instance['appear-from'];
		?>
		
		<table class = 'form-table'>
		
			<!-- Title -->
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id("title");?>'>
						<?php _e("Title",'bw');?>
					</label>
				</th>
				<th>
					<input
						type = 'text'
						name = '<?php echo $this->get_field_name("title");?>'
						id = '<?php echo $this->get_field_id('title');?>'
						value = '<?php echo $title;?>'/>
				</th>
			</tr>
			
			<!-- Tag ID -->
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id("tag-id");?>'>
						<?php _e("Tag Id",'bw');?>
					</label>
				</th>
				<th>
					<input
						type = 'text'
						name = '<?php echo $this->get_field_name("tag-id");?>'
						id = '<?php echo $this->get_field_id("tag-id");?>'
						value = '<?php echo $tagId;?>' />
				</th>
			</tr>
			
			<!-- Number OF Tabs -->
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id("num-of-tabs");?>'>
						<?php _e("Number Of Tabs",'bw');?>
					</label>
				</th>
				<th>
					<input
						type = 'number'
						min = '1'
						name = '<?php echo $this->get_field_name("num-of-tabs");?>'
						id = '<?php echo $this->get_field_id("num-of-tabs");?>'
						value = '<?php echo $num_of_tabs;?>' />
				</th>
			</tr>
			
		</table>
			
		<hr />
			
		<!-- Each Tab Options -->
		<?php for($tab = 0;$tab < $num_of_tabs;$tab++):?>
		<details style = 'background:#DDD;margin:10px;padding:10px;'>
			<summary><?php _e("Tab ".( $tab + 1 ),'bw');?></summary>
			
			<table class = 'form-table'>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id("tab-$tab-title");?>'>
							<?php _e("Title",'bw');?>
						</label>
					</th>
					<th>
						<input
							type = 'text'
							name = '<?php echo $this->get_field_name("tab-$tab-title");?>'
							id = '<?php echo $this->get_field_id("tab-$tab-title");?>'
							value = '<?php echo $tabs[$tab]['title'];?>' />
					</th>
				</tr>
				<tr>
					<th colspan = '2'>
						<label for = '<?php echo $this->get_field_id("tab-$tab-content");?>'>
							<?php _e("Content",'bw');?>
						</label>
					</th>
				</tr>
				<tr>
					<td colspan = '2'>
						<?php $contentList = get_posts(array('post_type' => 'content','numberposts' => -1));?>
						<select 
							name = '<?php echo $this->get_field_name("tab-$tab-content");?>'
							id = '<?php echo $this->get_field_id("tab-$tab-content");?>'>
						
							<option value = '0' <?php selected('0',$tabs[$tab]['content']);?>>
								<?php _e("None",'bw');?>
							</option>
							
							<?php foreach($contentList as $content):?>
						
							<option value = '<?php echo $content->ID;?>' <?php selected($content->ID,$tabs[$tab]['content']);?>>
								<?php echo $content->post_title;?>
							</option>
						
							<?php endforeach;?>
						</select>
					</td>
				</tr>
			</table>
		</details>
		<?php endfor;?>
		
		<hr />
		
		<details style = 'padding:10px;margin:10px;background:#EEE;'>
			<summary>
				<?php _e("Background",'bw');?>
			</summary>
			<table class = 'form-table'>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id("back-color");?>'>
							<?php _e("Background Color",'bw');?>
						</label>
					</th>
					<td>
					<?php bwbw_color_picker(
						$this->get_field_id('back-color'),
						$this->get_field_name('back-color'),
						$bg['color']);?>
					</td>
				</tr>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id("back-image");?>'>
							<?php _e("Image",'bw');?>
						</label>
					</th>
					<td>
						<img
							class = 'back-image tab-image_img'
							src = '<?php echo wp_get_attachment_image_src($bg['image'],'thumbnail')[0];?>'
							style = 'max-width:100%;padding-top:5px;'/>
						<input 
							type = 'hidden' 
							value = '<?php echo $bg['image'];?>'
							name = '<?php echo $this->get_field_name("back-image");?>'
							id = '<?php echo $this->get_field_id("back-image");?>'
							class = 'tab-image_id'/>
						<button
							style = 'position:relative'
							type = 'button'
							class = 'button button-primary custom_media_upload'
							id = 'tab-image'>
								<?php _e("Upload/Change Image",'bw');?>
								<input 	
									type = 'checkbox'
									style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'/>
						</button>
						<button
							type = 'button'
							class = 'button remove'
							style = 'position:relative'
							id = 'tab-image'>
							<?php _e("Remove Image",'bw');?>
							<input 	
								type = 'checkbox'
								style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;'
								id = "slide_<?php echo $i;?>_check"/>
						</button>
					</td>
				</tr>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id("back-opacity");?>'>
							<?php _e("Opacity",'bw');?>
						</label>
					</th>
					<td>
						<input
							type = 'range'
							min = '0'
							max = '100'
							step = '1'
							name = '<?php echo $this->get_field_name("back-opacity");?>'
							id = '<?php echo $this->get_field_id("back-opacity");?>'
							value = '<?php echo $bg['opacity'];?>' />
					</td>
				</tr>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id('back-position');?>'>
							<?php _e("Position",'bw');?>
						</label>
					</th>
					<td>
					<?php bwbw_bg_position(
					$this->get_field_id('back-position'),
					$this->get_field_name('back-position'));?>
					</td>
				</tr>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id('back-size');?>'>
							<?php _e("Size",'bw');?>
						</label>
					</th>
					<td>
						<?php $bgSizes = array(
						
							'100% 100%' => 'Full Size',
							'cover'		=> 'Cover',
							'contain'	=> 'Contain',
							'initial'	=> 'Image Size'
						);?>
						<select
							name = '<?php echo $this->get_field_name('back-size');?>'
							id = '<?php echo $this->get_field_id("back-size");?>'>
							<?php foreach($bgSizes as $val => $size):?>
							
							<option <?php selected($val,$bg['size']);?> value = '<?php echo $val;?>'>
								<?php _e($size,'bw');?>
							</option>
							
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for = '<?php echo $this->get_field_id('scroll-effect');?>'>
							<?php _e("Scroll Effect",'bw');?>
						</label>
					</th>
					<td>
						<input
							type = 'checkbox'
							name = '<?php echo $this->get_field_name("scroll-effect");?>'
							id = '<?php echo $this->get_field_id("scroll-effect");?>'
							<?php checked($bg['scroll-effect']);?> />
					</td>
				</tr>
			</table>
		</details>
		
		<table class = 'form-table'>
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id("color");?>'>
						<?php _e("Text Color",'bw');?>
					</label>
				</th>
				<td>
				<?php bwbw_color_picker(
					$this->get_field_id('color'),
					$this->get_field_name('color'),
					$color);?>
				</td>
			</tr>
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id("switch-effect");?>'>
						<?php _e("Switch Effect",'bw');?>
					</label>
				</th>
				<td>
					<?php $switch = array('none','slide','fade','flip');?>
					<select
						name = '<?php echo $this->get_field_name("switch-effect");?>'
						id = '<?php echo $this->get_field_id("switch-effect");?>'>
					<?php foreach($switch as $s):?>
						
						<option value = '<?php echo $s;?>' <?php selected($s,$switchEffect);?>>
							<?php _e(ucfirst($s),'bw');?>
						</option>
						
					<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for = '<?php echo $this->get_field_id("appear-on-scroll");?>'>
						<?php _e("Appear On Scroll",'bw');?>
					</label>
				</td>
				<td>
					<input
						type = 'checkbox'
						name = '<?php echo $this->get_field_name("appear-on-scroll");?>'
						id = '<?php echo $this->get_field_id("appear-on-scroll");?>'
						<?php checked(true,$appearOnScroll);?>/>
				</td>
			</tr>
		</table>
		
		<details style = 'padding:10px;background:#EEE;'>
		
			<summary><?php _e("Appear Options",'bw');?></summary>
		
			<table class = 'form-table'>
				<tr>
					<td>
						<label for = '<?php echo $this->get_field_id("appear-effect");?>'>
							<?php _e("Appear Effect",'bw');?>
						</label>
					</td>
					<td>
						<?php $appearEffects = array('fade','slide','flip');?>
						<select
							name = '<?php echo $this->get_field_name("appear-effect");?>'
							id = '<?php echo $this->get_field_id("appear-effect");?>'>
							<?php foreach($appearEffects as $effect):?>
							<option value = '<?php echo $effect;?>' <?php selected($effect,$appearEffect);?>>
								<?php _e(ucfirst($effect),'bw');?>
							</option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for = '<?php echo $this->get_field_id("appear-effect");?>'>
							<?php _e("Appear Effect",'bw');?>
						</label>
					</td>
					<td>
						<?php $afList = array('top','right','bottom','left');?>
						<select 
							name = '<?php echo $this->get_field_name("appear-from");?>'
							id = '<?php echo $this->get_field_id("appear-from");?>'>
							<?php foreach($afList as $from):?>
							<option value = '<?php echo $from;?>' <?php selected($from,$appearFrom);?>>
								<?php _e(ucfirst($from),'bw');?>
							</option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
			</table>
		</details>
		<?php
	}
	
	function widget($args,$instance) {
		
		$n = empty($instance['num-of-tabs']) ? 1:$instance['num-of-tabs'];
		$layoutStyle = "";
		$style = "";
		
		$switch_effect = empty($instance['switch-effect']) ? get_theme_mod('bw-t-switch-effect','none'):$instance['switch-effect'];
		
		$bg_color = empty($instance['back-color']) ? get_theme_mod('bw-t-bg-color','#ffffff'):$instance['back-color'];
		$layoutStyle = "background-color:". $bg_color .";";
		
		$bg_opacity = empty($instance['back-opacity']) ? get_theme_mod('bw-t-bg-opacity',100):$instance['back-opacity'];
		$layoutStyle .= "opacity:". ($bg_opacity / 100) .";";
		
		$bg_image = empty($instance['back-image']) ? get_theme_mod('bw-t-bg-image'):$instance['back-image'];
		$style = 'background-image:url('. wp_get_attachment_image_src($bg_image,'large')[0] .');';
		
		$bg_pos = empty($instance['back-position']) ? get_theme_mod('bw-t-bg-pos','center'):$instance['back-position'];
		$style .= 'background-position:'. $bg_pos .';';
		
		$bg_size = empty($instance['back-size']) ? get_theme_mod('bw-t-bg-size','auto'):$instance['back-size'];
		$style .= 'background-size:'. $bg_size .';';
		
		$bg_atta = empty($instance['bw-t-scroll-effect']) ? get_theme_mod('bw-t-scroll-effect',false):$instance['bw-t-scroll-effect'];
		if( $bg_atta != false )
			$style .= 'background-attachment:fixed;';
		
		$txt_color = empty($instance['color']) ? get_theme_mod('bw-t-txt-color','#000000'):$instance['color'];
		$style .= 'color:'. $txt_color .';';
		
		$appear = "";
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-t-appear-on-scroll',false):$instance['appear-on-scroll'];
		//Appear On Scroll Effect.
		if( $appear_on_scroll != false ) {
			
			$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-t-appear-effect','fade'):$instance['appear-effect'];
			$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-t-appear-from','left'):$instance['appear-from'];
			
			$appear = "appear-effect = '". $appear_effect ."' appear-from = '". $appear_from ."'";
		}
		
		$tag_id = empty($instance['tag-id']) ? '':"id = '".$instance['tag-id']."'";
		?>
		
		<section
			<?php echo $tag_id;?>
			<?php echo $appear;?>
			style = '<?php echo $style;?>' 
			class = 'tabs-widget <?php echo $switch_effect;?>' 
			tabs-count = "<?php echo $n;?>">
			
			<div style = '<?php echo $layoutStyle;?>' class = 'layout'></div>
			
			<?php if( !empty($instance['title']) ):?>
			<h2 class = 'widget-head'>
				<?php _e($instance['title'],'es');?>
			</h2>
			<?php endif;?>
			
			<header class = 'tab-head requireJs'>
			<?php $lang_dir = is_rtl() ? array('right','left'):array('left','right');?>
				
				<button
					class = 'screen-only' 
					id = 'tabs-left' 
					title = '<?php _e("Previous Tab",'bw');?>'>
					<i class = 'fas fa-caret-<?php echo $lang_dir[0];?>'></i>
				</button>
				
				<section class = 'tabs-header-container'>
				
					<?php for($th = 0;$th < $n;$th++):?>
				
						<button title = '<?php _e("Tab Number ".($th + 1),'bw');?>' id = 'tab-<?php echo $th;?>'>
							<?php echo empty($instance['tab-'.$th.'-title']) ? $th + 1:$instance['tab-'.$th.'-title'];?>
						</button>
					
					<?php endfor;?>
				
				</section>
				
				<button 
					class = 'screen-only' 
					id = 'tabs-right' 
					title = '<?php _e("Next Tab",'bw');?>'>
					<i class = 'fas fa-caret-<?php echo $lang_dir[1];?>'></i>
				</button>
				
			</header>
		
			<section class = 'tab-content'>
			<?php for($tb = 0;$tb < $n;$tb++):?>
				
				<?php 
					$contentId = empty($instance['tab-'.$tb.'-content']) ? 0:$instance['tab-'.$tb.'-content'];
					$content = get_post($contentId);
				?>
				
				<h2 style = 'text-align:center;display:none;' class = 'noJs'>
					<?php echo empty($instance['tab-'.$tb.'-title']) ? $tb + 1:$instance['tab-'.$tb.'-title'];?>
					<hr />
				</h2>
				
				<div id = 'tab-<?php echo $tb;?>-content'>
					<?php echo (!empty($content) && $content->post_type == 'content') ? $content->post_content:'';?>
				</div>
				
			<?php endfor;?>
			</section>
		
		</section>
		
		<?php
	}
	
	function update($new,$old) {
		
		$instance = $old;
		
		$instance['title'] = sanitize_title($new['title']);
		$instance['tag-id'] = esc_html($new['tag-id']);
		
		$instance['num-of-tabs'] = absint($new['num-of-tabs']);
		
		for($i = 0;$i < $instance['num-of-tabs'];$i++) {
			
			$instance['tab-'.$i.'-title'] = sanitize_title($new['tab-'.$i.'-title']);
			$instance['tab-'.$i.'-content'] = absint($new['tab-'.$i.'-content']);
		}
		
		$instance['back-color'] = sanitize_hex_color($new['back-color']);
		$instance['back-image'] = absint($new['back-image']);
		$instance['back-opacity'] = absint($new['back-opacity']);
		$instance['back-position'] = esc_html($new['back-position']);
		$instance['back-size'] = esc_html($new['back-size']);
		$instance['scroll-effect'] = rest_sanitize_boolean($new['scroll-effect']);
		$instance['color'] = sanitize_hex_color($new['color']);
		
		$instance['switch-effect'] = esc_html($new['switch-effect']);
		
		$instance['appear-on-scroll'] = rest_sanitize_boolean($new['appear-on-scroll']);
		$instance['appear-effect'] = esc_html($new['appear-effect']);
		$instance['appear-from'] = esc_html($new['appear-from']);
		
		return $instance;
	}
}

register_widget("se_tabs_widget");
?>