<?php

class BW_Customize_Image_List extends WP_Customize_Control {

    public $type = 'Image Choose List';
    public $grid;

    public function render_content() {
        
        $element_count = (is_null($this->grid) ? 2:absint($this->grid));
        $element_width = (100 / $this->grid) - $this->grid;?>

        <label for="<?php echo $this->id;?>"><?php echo $this->label;?></label>

        <div class="bw-image-list">
            <header>
                <input type="search" class = 'bw-search-image-list' />
                <button type="button" style = 'background:none;border:none;color:#000;'>
                    <i class="dashicons dashicons-no"></i>
                </button>
            </header>
            <ul>
                <?php foreach( $this->choices as $choice_value => $choice_img_src ):?>
                    <li style = 'width:<?php echo $element_width;?>%;'>
                        <img src="<?php echo $choice_img_src;?>" />
                        <input <?php $this->link();?> type="radio" name="<?php echo $this->id;?>" value = "<?php echo $choice_value;?>" <?php checked($choice_value,$this->value());?> />
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php }
}
?>