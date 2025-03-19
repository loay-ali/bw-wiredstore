<section class="wrap">
    <header>
        <h2>الطلبات مسبقة</h2>
        <div class = 'bw-switch'>
            <a class = 'button <?php echo ((isset($_GET['for']) && is_string($_GET['for']) && $_GET['for'] == 'requests') || empty($_GET['for'])) ? "button-primary":"";?>' href = "?page=bw-notify-me&for=requests">
                حسب الطلبات
            </a>
            <a class = 'button <?php echo (isset($_GET['for']) && is_string($_GET['for']) && $_GET['for'] == 'products') ? "button-primary":"";?>' href = "?page=bw-notify-me&for=products">
                حسب المنتجات
            </a>
			<hr />
            <a class = 'button' href="?page=bw-notify-me&operation=resend&nonce=<?php echo wp_create_nonce('bw-resend-notify-nonce');?>" style = 'background:#535a5f;color:#FFF;' onclick = 'if(confirm("هل أنت متاكد ؟") == false) { event.preventDefault();}'>
                أعادة أرسال الغير مرسل
            </a>
        </div>
    </header>
    <?php if( empty($_GET['for']) || ( is_string($_GET['for']) && $_GET['for'] == 'requests' ) )://By Requets?>
        <?php 
            require_once __DIR__ .'/../../inc/admin/form-tables/backorder-requests.php';
            $bw_table_requests = new BW_Backorder_Requests_Form_Table;
            $bw_table_requests->get_items();
        ?>

        <form method = "GET">
            <hr style = 'margin-top:25px;'/>
            <header style = 'margin:10px 0 0 0;padding:10px 0 0 0;'>
                <div class = 'bw-form-field'>
                    <label for = 'bw-search-requests'>
                        البحث
                    </label>
                    <input type = 'search' name = 's' id = 'bw-search-requests' class = 'form-control' autocomplete='off' value = '<?php echo $bw_table_requests->s;?>'/>
                    <button type = 'submit' class = 'button-primary bw-btn'>
                        <i class = 'dashicons dashicons-search'></i>
                    </button>
                </div>

                <!-- Request Status -->
                <div class = 'bw-form-field'>
                    <label for="bw-status-only">
                        نوع الطلب
                    </label>
                    <select name = 'bw-status-only' id = 'bw-status-only'>
                        <option value = ''>الكل</option>
                        <option value = '1' <?php selected($bw_table_requests->dedicated_inputs['status'],1);?>>لم يتم الأرسال</option>
                        <option value = '2' <?php selected($bw_table_requests->dedicated_inputs['status'],2);?>>تم الأرسال</option>
                    </select>
                </div>

                <!-- Stock Status -->
                <div class = 'bw-form-field'>
                    <label for = 'bw-product-stock-only'>
                        نوع المخزون
                    </label>
                    <select name = 'bw-product-stock-only' id = 'bw-product-stock-only'>
                        <option value = ''>الكل</option>
                        <option value = 'outofstock' <?php selected($bw_table_requests->dedicated_inputs['stock'],'outofstock');?>>غير موجود فى المخزون</option>
                        <option value = 'instock' <?php selected($bw_table_requests->dedicated_inputs['stock'],'instock');?>>موجود فى المخزون</option>
                    </select>
                </div>

                <!-- Contact Type -->
                <div class = 'bw-form-field'>
                    <label for="bw-customer-contact-only">نوع وسيلة التنبية</label>
                    <select name = 'bw-customer-contact-only' id = 'bw-customer-contact-only'>
                        <option value="">الكل</option>
                        <option value="phone" <?php selected($bw_table_requests->dedicated_inputs['contact'],'phone');?>>الهاتف</option>
                        <option value="email" <?php selected($bw_table_requests->dedicated_inputs['contact'],'email');?>>البريد الإلكترونى</option>
                        <option value="whatsapp" <?php selected($bw_table_requests->dedicated_inputs['contact'],'whatsapp');?>>الواتس اب</option>
                    </select>
                </div>

                <!-- Request Release Date -->
                <div class = 'bw-form-field'>
                    <label for = "bw-request-date">تاريخ الطلب</label>
                    <input type = 'date' name = 'bw-request-date' id = 'bw-request-date' value = '<?php echo $bw_table_requests->dedicated_inputs['date'];?>' />
                </div>

                <button type = 'button' onclick = 'document.getElementById("bw-request-date").value = "";' class = 'button bw-btn'><i class = 'dashicons dashicons-no'></i></button>
                <?php submit_button( 'الفلترة' );?>
            </header>
            <input type = 'hidden' name = 'page' value = 'kelvin-backorders' />
        </form>
        
        <form method = 'POST'>
            <?php $bw_table_requests->display();?>
        </form>

        <footer>
            <?php echo $bw_table_requests->pagination('requests');?>
        </footer>
    <?php else://By Products?>
        <?php 
            require_once __DIR__ .'/../../inc/admin/form-tables/backorder-products.php';
            $bw_table_products = new BW_Backorder_Products_Form_Table;
            $bw_table_products->get_items();
        ?>
        <form method = 'GET'>
            <header style = 'margin:10px 0;padding:10px 0;display:inline-flex;align-items:center;justify-content:flex-start;'>
                <hr />
                
                <!-- Keyword Search -->
                <div class = 'bw-form-field'>
                    <label for="s">البحث</label>
                    <input type = "search" name = "s" id = "s" value = '<?php echo $bw_table_products->dedicated_inputs['search'];?>' class = 'form-control'/>
                    <button type = "submit" class = 'button-primary bw-btn'>
                        <i class="dashicons dashicons-search"></i>
                    </button>
                </div>

                <!-- Product Stock Status -->
                <div class = 'bw-form-field' style = 'margin-inline-end:10px;'>
                    <label for="bw-stock-only">حالة المخزون</label>
                    <select name="bw-stock-only" id="bw-stock-only">
                        <option value="">الكل</option>
                        <option value="outofstock" <?php selected($bw_table_products->dedicated_inputs['stock'],'outofstock');?>>غير متوفر</option>
                        <option value="instock" <?php selected($bw_table_products->dedicated_inputs['stock'],'instock');?>>متوفر </option>
                    </select>
                </div>

                <?php submit_button('بحث');?>
            </header>
            <input type = 'hidden' name = 'page' value = 'kelvin-backorders' />
            <input type = 'hidden' name = 'for' value = 'products' />
        </form>
        <form method = "POST">
            <?php $bw_table_products->display();?>
        </form>

        <?php $bw_table_products->pagination('products');?>
    <?php endif;?>
</section>