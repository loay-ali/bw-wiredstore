<style>
    #bw-qa-list { max-width:500px;}
</style>
<table class="form-table widefat" id = 'bw-qa-list'>
	<thead>
		<tr>
			<td>#</td>
			<td><?php _e("Title");?></td>
			<td><?php _e("Content");?></td>
		</tr>
	</thead>
	<tbody>
	<?php $counter = 1;foreach($args['vals'] as $code => $item):?>
		<tr>
			<td>
				<?php echo $counter++;?>
			</td>
			<td>
				<input
					type    = "text"
					name    = "bw_content_qa[title][]"
					value   = "<?php echo $item['title'];?>" />
			</td>
			<td>
				<textarea name = 'bw_content_qa[content][]'><?php echo $item['content'];?></textarea>
			</td>
			<td>
                <input type="hidden" name="bw_content_qa[code][]" value="<?php echo empty($item['code']) ? '':esc_attr($item['code']);?>" />
				<button type = "button" class = "bw-remove-qa">
					<i class = "dashicons dashicons-trash"></i>
				</button>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<button class = 'button button-primary' type = 'button' id = 'bw-add-new-qa'>
					<?php _e("Add");?> +
				</button>
			</td>
		</tr>
	</tfoot>
</table>