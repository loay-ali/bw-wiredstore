<style>
    #bw-qa-list { max-width:500px;}
</style>

<form action="POST">
    <table class="form-table widefat">
        <thead>
            <tr>
                <td>#</td>
                <td><?php _e("Title");?></td>
                <td><?php _e("Content");?></td>
                <td><?php _e("Disable For This Product ?",'bw');?></td>
            </tr>
        </thead>
        <tbody>
        <?php $counter = 1;foreach($args['vals'] as $code => $item):?>
            <tr>
                <td>
                    <?php echo $counter++;?>
                </td>
                <td>
                    <label for = "bw_excluded_qa[<?php echo $code;?>]"><?php echo $item['title'];?></label>
                </td>
                <td>
                    <p><?php echo $item['content'];?></p>
                </td>
                <td>
                    <input
                        type = "checkbox"
                        name = "bw_excluded_qa[]"
                        id   = "bw_excluded_qa[]"
                        value = "<?php echo $code;?>"
                        <?php checked(in_array($code,$args['products_exclude']),true);?> />
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</form>