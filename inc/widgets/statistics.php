<?php

//Define The Statistics Widget Class
class se_statistics_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct("se_statistics_widget","Statistics Widget",array(
		'classname' => "se_statistics_widget"));
	}
	
	//Checking Method.
	private function check($value,$default = '') {
		
		return empty($value) ? $default:$value;
	}

	//Displaying Inputs.
	private function custom_input($type='text',$name=null,$id=null,$val=null,$i = 0,$options=array()) {
		
		//Filter Inputs.
		$types_list = array('text','img','number','position','opacity','checkbox','color','select');
		$type = in_array($type,$types_list) ? $type:'text';
		
		echo "<tr><td><label for = '". $this->get_field_id($id) ."'>". __($name,'bw') ."</label></td>";
		
		echo "<td>";
		
		if($type == 'img') {
			echo "<img
					src = '".wp_get_attachment_image_src($val,'thumbnail')[0]."'
					class = 'image_". $i ."_img'
					style = 'max-width:100%;'/>";
			echo "<input
					type = 'hidden'
					value = '".$val."'
					class = 'image_".$i."_id'
					id = '".$this->get_field_id($id)."'
					name = '".$this->get_field_name($id)."'/>";
			echo "<button 
					type = 'button'
					class = 'button custom_media_upload'
					id = 'image_".$i."' 
					style = 'position:relative;'>";
					
					_e("Upload/Change Image",'bw');
					echo "<input
							type = 'checkbox'
							style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;' />";
			echo "</button>";
			
			//Remove Button
			if( !empty($val) ) {
				echo "<button
						class = 'button remove'
						type = 'button'
						style = 'position:relative;'
						id = 'image_".$i."'>
						". __("Remove",'bw') ."
							<input
								type = 'checkbox'
								class = 'image_".$i."_check'
								style = 'opacity:0;z-index:5;width:100%;height:100%;top:0;left:0;position:absolute;' />
						</button>";
			}
			
		}elseif($type == 'select') {
			
			echo "<select
					name = '". $this->get_field_name($id) ."'
					id = '". $this->get_field_id($id) ."'>";
				
				foreach($options as $key => $value) {
				
					echo "<option value = '". $key ."' ". selected($key,$val) .">". __($value,'bw') ."</option>";
					
				}
				
			echo "</select>";
			
		}elseif ($type == 'checkbox') {
			echo "<input
					type = 'checkbox'
					id = '".$this->get_field_id($id)."'
					name = '".$this->get_field_name($id)."' 
					". checked($val) ."/><br />";
		}elseif( $type == 'color' ) {
			
			bwbw_color_picker(
			$this->get_field_id($id),
			$this->get_field_name($id),
			$val);
		}elseif( $type == 'position' ) {
			
			bwbw_bg_position(
				$this->get_field_id($id),
				$this->get_field_name($id));
		}elseif( $type == 'opacity' ) {
			
			echo "<input
					type = 'range'
					min = '0'
					max = '100'
					step = '1'
					value = '". $val ."'
					id = '". $this->get_field_id($id) ."'
					name = '". $this->get_field_name($id) ."' />";
		}else {
			echo "<input 
					type = '".$type."' 
					id = '". $this->get_field_id($id) ."' 
					name = '". $this->get_field_name($id) ."'
					value = '". $val ."'/>";
		}
		
		echo "</td>";
	}
	
	function form ($instance) {
		
		//Title
		$head = $this->check(@$instance['head']);
		
		//Id Tag To Reach This Element By Scrolling.
		$tag_id = $this->check(@$instance['tag-id']);
		
		//Number Of Statistics To Show.
		$num_of_stats = $this->check(@$instance['num-of-stats'],1);
		
		$stats = array();
		for($i = 0;$i < $num_of_stats;$i++) {
			
			$stats[$i]['title'] = $this->check(@$instance['stat-'.$i.'-title']);
			$stats[$i]['pic'] = $this->check(@$instance['stat-'.$i.'-pic']);
			$stats[$i]['bg-color'] = $this->check(@$instance['stat-'.$i.'-bg-color'],get_theme_mod('bw-s-stat-bg-color','#ffffff'));
			$stats[$i]['txt-color'] = $this->check(@$instance['stat-'.$i.'-txt-color'],get_theme_mod('bw-s-stat-txt-color','#000000'));
			$stats[$i]['num'] = $this->check(@$instance['stat-'.$i.'-num'],0);
			$stats[$i]['out-of'] = $this->check(@$instance['stat-'.$i.'-out-of']);
		}
		
		//Text Color.
		$txt_col = $this->check(@$instance['txt-color'],get_theme_mod('bw-s-txt-color','#000000'));
		
		//Background Section.
		$background_img = $this->check(@$instance['stat-back-img'],get_theme_mod('bw-s-bg-image'));
		$background_col = $this->check(@$instance['background-col'],get_theme_mod('bw-s-bg-color','#ffffff'));
		$background_pos = $this->check(@$instance['background-pos'],get_theme_mod('bw-s-bg-pos','center'));
		$background_size = $this->check(@$instance['background-size'],get_theme_mod('bw-s-bg-size','auto'));
		$background_re = $this->check(@$instance['background-repeat'],0);//Repeat.
		$background_atta = $this->check(@(bool)$instance['background-atta'],get_theme_mod('bw-s-bg-atta',false));
		$background_opacity = empty($instance['background-opacity']) ? get_theme_mod('bw-s-bg-opacity',100):$instance['background-opacity'];
		
		//Appear On Scroll.
		$appear_on_scroll = $this->check(@$instance['appear-on-scroll'],get_theme_mod('bw-s-appear-on-scroll',false));
		$appear_effect = $this->check(@$instance['appear-effect'],get_theme_mod('bw-s-appear-effect','fade'));
		$appear_from = $this->check(@$instance['appear-from'],get_theme_mod('bw-s-appear-from','left'));
		
		/* Customization Panel View */
		echo "<table class = 'form-table'>";
		
		//Title
		$this->custom_input("text",'Title','head',$head);
		
		//Tag Id.
		$this->custom_input('text','Id Tag','tag-id',$tag_id);
		
		//Number Of Statistics.
		$this->custom_input('number','Number Of Statistics','num-of-stats',$num_of_stats);
		
		echo "</table>";
		
		//Each Stat Options
		for($i = 0;$i < $num_of_stats;$i++) {
			
			echo "<details style = 'padding:10px;margin:10px 0;background:#DDD;'>";
			echo "<summary>".__("Stat ".($i + 1),'bw')."</summary>";
			echo "<table class = 'form-table'>";

			//Head Title
			$this->custom_input('text','Statistic Title','stat-'.$i.'-title',$stats[$i]['title']);
		
			//Picture
			$this->custom_input("img",'Picture','stat-'.$i.'-pic',$stats[$i]['pic'],$i);
		
			//Bg Color.
			$this->custom_input("color","Background Color",'stat-'.$i.'-bg-color',$stats[$i]['bg-color']);

			//Text Color.
			$this->custom_input("color","Text Color",'stat-'.$i.'-txt-color',$stats[$i]['txt-color']);
		
			//Number.
			$this->custom_input("number","Number",'stat-'.$i.'-num',$stats[$i]['num']);
			
			//Out Of (Optional).
			$this->custom_input("number","Out Of (Optional)",'stat-'.$i.'-out-of',$stats[$i]['out-of']);

			echo "</table>";
			echo "</details>";
		}
		
		echo "<table class = 'form-table'>";
		
		//Text Color.
		$this->custom_input("color","Text Color","txt-color",$txt_col);
		
		echo "</table>";
		
		//Background Section.
		echo "<details style = 'padding:10px;margin:10px 0;background:#EEE;'>";
		echo "<summary>".__("Background",'bw')."</summary>";
		echo "<table class = 'form-table'>";
		
			//Background Color.
			$this->custom_input("color","Background Color",'background-col',$background_col);
			
			//Background Image.
			$this->custom_input("img","Background Image","stat-back-img",$background_img,'base');
			
			//Background Image Size.
			$this->custom_input("select","Background Size","background-size",$background_size,0,array(
			
				"cover" => "Cover",
				"contain" => "Contain",
				"100% 100%" => "Fit" ));
		
			//Background Image Position.
			$this->custom_input("position","Background Position","background-pos",$background_pos);
		
			//Background Image Repeat.
			$this->custom_input("checkbox","Repeat Background Image ",'background-repeat',$background_re);
			
			//Parallox Effect.
			$this->custom_input("checkbox","Scrolling Effect ","background-atta",$background_atta);
			
			//Opacity.
			$this->custom_input('opacity','Opacity','background-opacity',$background_opacity);
		
		echo "</table></details>";
		
		echo "<table class = 'form-table'>";
		
		//Appear On Scroll.
		$this->custom_input("checkbox","Appear On Scroll",'appear-on-scroll',$appear_on_scroll);
		
		echo "</table>";
			
		echo "<details style = 'padding:10px;margin:10px 0;background:#EEE;'>";
		echo "<summary>".__("Appear Options",'bw')."</summary>";
		echo "<table class = 'form-table'>";
		
			//Appear Effect.
			$this->custom_input("select","Appear Effect","appear-effect",$appear_effect,0,array(
			
			"fade" => "Fade",
			"slide" => "Slide",
			"flip" => "Flip" ));
		
			//Appear From ?
			$this->custom_input("select",'Appear From','appear-from',$appear_from,0,array(
			
			"top" => "Top",
			"right" => "Right",
			"bottom" => "Bottom",
			"left" => "Left" ));
			
		echo "</table></details>";
	}
	
	//Showing The Widget.
	function widget($args,$instance) {
		
		$id = empty($instance['tag-id']) ? '':'id = "'. $instance['tag-id'] .'"';
		
		$style = "";
		$layout_style = '';
	
		$txt_color = empty($instance['txt-color']) ? get_theme_mod('bw-s-txt-color','#000000'):$instance['txt-color'];
		$style .= "color:". $txt_color .";";
		
		$bg_image = empty($instance['stat-back-img']) ? get_theme_mod('bw-s-bg-image'):$instance['stat-back-img'];
		$style .= "background-image:url(". wp_get_attachment_image_src($bg_image,'large')[0] .");";
		
		$bg_size = empty($instance['background-size']) ? get_theme_mod('bw-s-bg-size','auto'):$instance['background-size'];
		$style .= "background-size:". $bg_size .";";
		
		$bg_pos = empty($instance['background-pos']) ? get_theme_mod('bw-s-bg-pos','center'):$instance['background-pos'];
		$style .= "background-position:". $bg_pos .";";
		
		if( !empty($instance['background-repeat']) ) $style .= "background-repeat:". $instance['background-repeat'] .";";
		
		$bg_scroll_effect = empty($instance['background-atta']) ? get_theme_mod('bw-s-bg-atta',false):$instance['background-atta'];
		if( $bg_scroll_effect ) $style .= "background-attachment:fixed;";
		
		$bg_opacity = empty($instance['background-opacity']) ? get_theme_mod('bw-s-bg-opacity',100):$instance['background-opacity'];
		$layout_style .= "opacity:". ($bg_opacity / 100) .";";
		
		$bg_color = empty($instance['background-col']) ? get_theme_mod('bw-s-bg-color','#ffffff'):$instance['background-col'];
		$layout_style .= "background-color:". $bg_color .";";
		
		$appear = "";
		$appear_on_scroll = empty($instance['appear-on-scroll']) ? get_theme_mod('bw-s-appear-on-scroll',false):$instance['appear-on-scroll'];
		//Appear On Scroll Effect.
		if($appear_on_scroll) {
			
			$appear_effect = empty($instance['appear-effect']) ? get_theme_mod('bw-s-appear-effect','fade'):$instance['appear-effect'];
			$appear_from = empty($instance['appear-from']) ? get_theme_mod('bw-s-appear-from','left'):$instance['appear-from'];
			
			$appear = "appear-effect = '". $appear_effect ."' appear-from = '". $appear_from ."'";
		}
		
		?>
		<section class = 'stat-widget' <?php echo $id . $appear; ?> style = '<?php echo $style; ?>'>
		
			<header>
			
				<?php if( !empty($instanc['head']) ):?>
				<h2 class = 'widget-head'>
					<?php _e($instance['head'],'es'); ?>
				</h2>
				<?php endif;?>
			
			</header>
			
			<div id = 'stats-list'>
			
				<div class = 'layout' style = '<?php echo $layout_style; ?>'></div>
				
				<?php
					$num_of_stats = empty($instance['num-of-stats']) ? 0:absint($instance['num-of-stats']);
					for($i = 0;$i < $num_of_stats;$i++): ?>
			
				<?php $stat_number = empty($instance['stat-'.$i.'-num']) ? 0:$instance['stat-'.$i.'-num'];
					if( !empty($instance['stat-'.$i.'-out-of']) ) { $stat_number = round(($stat_number / $instance['stat-'.$i.'-out-of']) * 100) . " %"; } ?>

					<div id = 'stat-<?php echo $i; ?>'>
					
						<h3>
							<?php echo empty($instance['stat-'.$i.'-title']) ? '':$instance['stat-'.$i.'-title']; ?>
						</h3>
						
						<?php echo wp_get_attachment_image($instance['stat-'.$i.'-pic'],'thumbnail');?>
							
						<h4 class = 'stat-number' style = 'font-weight:bolder;'>
							<?php echo $stat_number; ?>
						</h4>
						
						<p>
							<?php echo empty($instance['stat-'.$i.'-content']) ? null:var_dump($instance['stat-'.$i.'-content']);?>
						</p>
					
					</div>
			
				<?php endfor; ?>
			
			</div>
		
		</section>
		
		<?php
	}
	
	//Updating Widget Options.
	function update($new,$old) {
		
		$instance = $old;
		
		$instance['head'] = esc_html($new['head']);
		$instance['tag-id'] = esc_html($new['tag-id']);
		$instance['num-of-stats'] = absint($new['num-of-stats']);
		
		$n = $instance['num-of-stats'];
		for($i = 0;$i < $n;$i++) {
			
			$instance['stat-'. $i .'-title'] = esc_html($new['stat-'. $i .'-title']);
			$instance['stat-'. $i .'-pic'] = absint($new['stat-'. $i . '-pic']);
			$instance['stat-'. $i .'-bg-color'] = sanitize_hex_color($new['stat-'. $i . '-bg-color']);
			$instance['stat-'. $i .'-txt-color'] = sanitize_hex_color($new['stat-'. $i . '-txt-color']);
			$instance['stat-'. $i .'-num'] = absint($new['stat-'. $i . '-num']);
			$instance['stat-'. $i .'-out-of'] = absint($new['stat-'. $i . '-out-of']);	
		}
		
		$instance['txt-color'] = sanitize_hex_color($new['txt-color']);
		
		$instance['background-col'] = sanitize_hex_color($new['background-col']);
		$instance['stat-back-img'] = absint($new['stat-back-img']);
		$instance['background-pos'] = esc_html($new['background-pos']);
		$instance['background-repeat'] = rest_sanitize_boolean($new['background-repeat']);
		$instance['background-atta'] = rest_sanitize_boolean($new['background-atta']);
		$instance['background-opacity'] = absint($new['background-opacity']);
		
		$instance['appear-on-scroll'] = rest_sanitize_boolean($new['appear-on-scroll']);
		$instance['appear-effect'] = esc_html($new['appear-effect']);
		$instance['appear-from'] = esc_html($new['appear-from']);
		
		return $instance;
	}
}

//Register The Widget.
register_widget("se_statistics_widget");

?>