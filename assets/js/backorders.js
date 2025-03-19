(function($){

    //Change Notify Me Type.
    $('body').on('click','#bw-switch-notify-me-type button',e => {

        const $ele = $(e.currentTarget);

        $ele.addClass('active').siblings('.active').removeClass('active');

        $('#bw-notify-my-btn').prop('disabled',false);

        const $input = $('#bw-notify-me-email');
        const $input_parent = $input.parent();

        switch( $ele[0].dataset['option'] ) {

            case 'email':
                $input.attr('type','email').attr('placeholder','البريد الإلكترونى الخاص بك').attr('value',bw_notify_object['bw-useremail']).val(bw_notify_object['bw-useremail']);
                $('#bw-notify-me-type').val('email').attr('value','email');
                $input_parent.addClass('is-email').removeClass('is-phone');
            break;

            case 'phone':
				$input.attr('type','tel').attr('placeholder','رقم الهاتف الخاص بك').attr('value',bw_notify_object['bw-userphone']).val(bw_notify_object['bw-userphone']);
				$('#bw-notify-me-type').val('phone').attr('value','phone');
                $input_parent.addClass('is-phone').removeClass('is-email');
			break;
			
            /*case 'whatsapp':
                $input.attr('type','tel').attr('placeholder','رقم الهاتف الخاص بك').attr('value',bw_notify_object['bw-userphone']).val(bw_notify_object['bw-userphone']);
                $('#bw-notify-me-type').val('whatsapp').attr('value','whatsapp');
                $input_parent.addClass('is-phone').removeClass('is-email');
            break;*/

        }
    });

    //Notify Me ( Remove ).
    $('body').on('click','.bw-notify-my-btn-remove[bw-item]',e => {

        e.preventDefault();

        const ele = $(e.currentTarget);
        const product = Math.abs(ele.attr('bw-item'));

        ele.addClass('bw-is-loading');

        $.post(
            bw_notify_object['ajax-url'],
            {action: "bw_notify_me_remove",nonce: bw_notify_object['nonce-remove'],product},
            res => {
                if( res == '1' || res == 1 ) {

                    const bw_table = ele.parents('table');

                    ele.parents('tr').remove();

                    console.log(bw_table[0].children);

                    if( bw_table[0].children[0].children.length == 0 ) {

                        $("<div class = 'text-center' style = 'font-size:30px;'><h3>لا توجد تنبيهات حالياً</h3><i class='fa fa-bell'></i></div>").insertBefore(bw_table);
                        bw_table.remove();
                    }
                }
            }
        ).always(() => {

            ele.removeClass('bw-is-loading');
        });
    });

    $('body').on('input','#bw-notify-me-input',e => {

        $(e.currentTarget).parent().removeClass('bw-error').find('.bw-error-content').remove();
    });

    //Notify Me ( Add ).
    $('body').on('click','#bw-notify-my-btn',e => {

        e.preventDefault();

        const email_or_phone = $('#bw-notify-me-email').val();
        const type = $('#bw-notify-me-type').val();
        const product = $('#bw-notify-me-product-id').val();

        if( email_or_phone == undefined || product == undefined || email_or_phone == '' || product == '' || type == '' )
            return;

        const ele = $(e.currentTarget);

        //Initiate Loading.
        ele.addClass('bw-is-loading');

        $.post(
            bw_notify_object['ajax-url'],
            {action: 'bw_notify_me',nonce: bw_notify_object['ajax-nonce'],type,email_or_phone,product},
            res => {

                if( res == '1' || res == 1 ) {

                    //Done.
                    $('#bw-notify-me-section-container').hide();
                    $('#bw-notify-me-section-success').show();
                }else {

                    ele.parent().addClass('bw-error');

                    //Error In Input.
                    if( type == 'phone' )
                        ele.parent().append("<span class = 'bw-error-content'><i class = 'extra-icons icon-warning'></i> رقم الهاتف غير صحيح</span>");
                    else
                        ele.parent().append("<span class = 'bw-error-content'><i class = 'extra-icons icon-warning'></i> البريد الإلكترونى غير صحيح</span>");
                }
        }).always(() => {

            //Disable Loading.
            ele.removeClass('bw-is-loading');
        });
    });

})(jQuery);