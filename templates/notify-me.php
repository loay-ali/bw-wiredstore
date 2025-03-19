<?php

global $product;
$bw_email = is_user_logged_in() ? wp_get_current_user()->user_email:'';
$bw_phone = is_user_logged_in() ? get_user_meta(get_current_user_id(),'billing_phone',true):'';
$bw_is_in_backorder = BW_WS_Back_Orders::is_in_backorder($bw_email,$bw_phone,$product->get_id());

?>
<section id = 'bw-notify-me-section'>
    <div id = 'bw-notify-me-section-container' style = 'display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;<?php echo $bw_is_in_backorder == true ? 'display:none;':'';?>'>
        <p style = 'width:100%;'>
            راسلنى عند توفر المنتج
        </p>
        <div class = "bw-field">
            <form method = 'POST' style = 'display:flex;width:100%;' id = 'bw-notify-me-form-container'>
                <div class = 'bw-field' id = 'bw-notify-me-input'>
                    <input id = 'bw-notify-me-email' autocomplete = 'email' name = 'email' type = 'email' placeholder = 'البريد الإلكترونى الخاص بك' value = '<?php echo $bw_email;?>' style = 'width:100%;' />
                </div>
                <button type = "button" class = 'primary' style = 'margin-inline-start:10px;' id = 'bw-notify-my-btn'>
                <?php _e("Activate",'bw');?>
                </button>
                <input type = 'hidden' id = 'bw-notify-me-product-id' value = '<?php echo $product->get_id();?>' />
                <input type = 'hidden' id = 'bw-notify-me-type' value = 'email' />
                <section style = 'border-inline-start:2px solid #AAA;padding-inline:10px;margin-inline:10px;'>
                    <label style = 'font-size:10px;'><?php _e("Way To Notify",'bw');?></label>
                    <section id = 'bw-switch-notify-me-type'>
                        <button type = 'button' id = 'bw-switch-phone-label' data-option = 'phone'>
                            <i class = 'bwi bwi-phone'></i>
                        </button>
                        <button type = 'button' data-option = 'email' id = 'bw-switch-email-label' class = 'active'>
                            <i class = 'bwi bwi-email'></i>
                        </button>
                    </section>
                </section>
            </form>
        </div>
    </div>
    <div id = 'bw-notify-me-section-success' style = 'color:#28a745;font-size:18px;<?php echo $bw_is_in_backorder == false ? 'display:none;':'';?>'>
        <i class="bwi bwi-check-circle"></i>
        <?php _e("Notification Is On For This Product",'bw');?>
    </div>
    <hr />
</section>