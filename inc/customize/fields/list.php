<?php

	class BW_Customize_List extends WP_Customize_Control {

		public $type = 'list';

		public function render_content() {?>
			<section class="bw-customize-list">
				<header style = 'display:flex;'>
					<input type="search" name="bw-list-search" id="bw-list-search" placeholder='<?php _e("Search...",'bw');?>' onkeyup = "Array.from(document.getElementById('bw-list-content-<?php echo $this->id;?>').children).forEach((ele) => { ele.style.display = (ele.innerText.search(this.value) != -1 ? 'flex':'none');});"/>
					<button style = 'background:none;border:none;color:#AAA;' type='button' onclick = 'document.getElementById("bw-list-search").value = "";Array.from(document.getElementById("bw-list-content-<?php echo $this->id;?>").children).forEach((ele) => { ele.style.display = "flex";});'><i class = 'dashicons dashicons-no'></i></button>
				</header>
					<ul id = 'bw-list-content-<?php echo $this->id;?>' style = 'padding:10px;max-height:60vh;overflow:auto;'>
						<?php foreach( $this->choices as $choice ):?>
							<li style = 'display:flex;justify-content:space-between;padding:5px;border-bottom:1px solid #AAA;'>
								<?php echo $choice['title'];?>
								<input <?php $this->link();?> type="radio" name="bw-list-choice[]" id="bw-list-choice[]" value = '<?php echo $choice['value'];?>' <?php checked($this->value(),$choice['value']);?>/>
							</li>
						<?php endforeach;?>
					</ul>
			</section>
		<?php }
	}
?>