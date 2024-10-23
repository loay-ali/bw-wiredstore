<?php

class BW_Contact_Info extends WP_Widget {
	
	private $types = array('phone','e-mails','application','social');
	
	private function findSiteName($link) {
		
		$link = parse_url($link,1);
		$link = explode('.',$link);
		
		if(count($link) < 2)
			return false;
		
		return array_reverse($link)[1];
	}
	
	function __construct() {
		
		parent::__construct('bw_contact_info',"Contact Info",array(
		
			'classname' => 'bw_contact_info'
		));
	}
	
	function form($instance) {
		
		$title = empty($instance['title']) ? '':$instance['title'];
		$type = empty($instance['type']) ? '':$instance['type'];
		$list = empty($instance['list']) ? null:$instance['list'];
		
		?>
		
		<table class = 'form-table'>
		
			<!-- Widget Title -->
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id('title');?>'>
						<?php _e("Title",'bw');?>
					</label>
				</th>
				<td>
					<input
						type = 'text'
						name = '<?php echo $this->get_field_name('title');?>'
						id = '<?php echo $this->get_field_id('title');?>'
						value = '<?php echo $title;?>' />
				</td>
			</tr>
			
			<!-- List Type -->
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id('type');?>'>
						<?php _e("Type",'bw');?>
					</label>
				</th>
				<td>
					<select
						id = '<?php echo $this->get_field_id('type');?>'
						name = '<?php echo $this->get_field_name('type');?>'>
						
						<?php foreach($this->types as $t):?>
						
							<option value = '<?php echo $t;?>' <?php selected($t,$type);?>>
								<?php echo ucfirst($t);?>
							</option>
						
						<?php endforeach;?>
						
					</select>
				</td>
			</tr>
		
			<!-- Choose List -->
			<?php $lists = wp_get_nav_menus();?>
			<tr>
				<th>
					<label for = '<?php echo $this->get_field_id('list');?>'>
						<?php _e("List",'bw');?>
					</label>
				</th>
				<td>
					<select
						name = '<?php echo $this->get_field_name('list');?>'
						id = '<?php echo $this->get_field_id('list');?>'>
						
						<?php foreach($lists as $l):?>
						
							<option
								<?php selected($l->term_id,$list);?>
								value = '<?php echo $l->term_id;?>'>
								
								<?php echo $l->name;?>
								
							</option>
						
						<?php endforeach;?>
						
					</select>
				</td>
			</tr>
		
		</table>
		
		<?php
	}
	
	function widget($args,$instance) {
		
		$title = empty($instance['title']) ? '':$instance['title'];
		$type = empty($instance['type']) ? '':$instance['type'];
		$list = empty($instance['list']) ? '':$instance['list'];
		
		if( $type == '' && $list == '' )
			return;
		
		$items = wp_get_nav_menu_items($list);
		?>
		
		<ul class = 'menu-<?php echo $type;?>'>
		<?php foreach($items as $i):?>
		
			<li>
			<?php switch($type):
				
				//Social Media Links.
				case 'social': 
					
					$siteName = $this->findSiteName($i->url);?>
					<a
						title = "<?php $siteName != false ? _e("Visit On ". $siteName,'bw'):'';?>"
						href = '<?php echo $i->url;?>' 
						target = '_blank'></a>
				
				<?php break;
				
				//Application Links.
				case 'application': ?>
				
					<?php $bwApp = strchr($i->url,'googleplay') == false ? 'app-store':'google-play';?>
					<a 	class = 'bw-app-<?php echo $bwApp;?>'
						href = '<?php echo $i->url;?>' 
						target = '_blank'
						title = '<?php _e("Download The App On ". ($bwApp == 'google-play' ? 'Google Play':'App Store'),'bw');?>'>
						<i class = 'fab fa-<?php echo $bwApp == 'app-store' ? 'apple':'google-play';?>'></i>
						<?php _e("Get It On",'bw'); ?>
						<strong>
							<?php echo str_replace('-',' ',ucfirst($bwApp)); ?>
						</strong>
					</a>
				
				<?php break;
				
				case 'phone':
				case 'e-mails':
					$label = $type == 'phone' ? 'Phone Number':'E-mail Address';?>
					
					<span aria-label = "<?php _e($label,'bw');?>">
						<?php echo $i->title; ?>
					</span>
				<?php break;
			
			endswitch;?>
			</li>
		
		<?php endforeach;?>
		</ul>
		
		<?php
	}
	
	/* To Be Changed */
	function update($new,$old) {
		
		$ins = $old;
		
		$ins['title'] 	= sanitize_text_field($new['title']);
		$ins['type'] 	= in_array($new['type'],$this->types) ? $new['type']:'';
		$ins['list'] 	= absint($new['list']);
		
		return $ins;
	}
}

register_widget("BW_Contact_Info");
?>