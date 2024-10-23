<?php

class BW_Color_Choice extends WP_Customize_Control {

    public $type = 'color_choice';

    public function render_content() {
        
        $bw_color_varies = array(
        'red'       => __("Red"),
        'green'     => __("Green"),
        'blue'      => __("Blue"),
        
        'yellow'    => __("Yellow"),
        'orange'    => __("Orange"),
        
        'purple'    => __("Purple"),
        'pink'      => __("Pink"),

        'white'     => __("White"),
        'black'     => __("Black"));?>

        <label for = '<?php echo $this->id;?>'><?php echo $this->label;?></label>
        <select <?php $this->link();?> name="<?php echo $this->id;?>" id="<?php echo $this->id;?>">
            <?php foreach( $bw_color_varies as $value => $title ):?>
                <option value="<?php echo $value;?>" <?php selected($value,$this->value());?>><?php echo $title;?></option>
            <?php endforeach;?>
        </select>
    <?php }
}
?>