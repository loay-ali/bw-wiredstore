<?php
/**
 * Comments Field & Comments List Template
 *
 * @package bw-wiredstore
 */
?>
<section class = 'comments'>
	
	<h3>
		<?php printf(_n("%d Comment","%d Comments",'bw'),get_comments_number());?>
	</h3>
	
	<?php

	wp_list_comments(array(
		"style" => "ul",
		"max_depth" => 3 ));

	//Comment Form.
	comment_form(array(
		'comment_field' => '<textarea cols="45" rows="8" name = "comment" placeholder = "'. __("Leave a Comment...",'bw') .'"></textarea>',
		
		'fields' => array(
		
			'url' 	=> '',
			'author'=> sprintf('<label for = "author">* '. __("Name",'bw') .':</label> <input type = "text" id = "author" name = "author" value = "%s" />',esc_attr($commenter['comment_author'])),
			'email'	=> sprintf('<label for = "email">* '. __("E-Mail",'bw') .':</label> <input type = "text" id = "email" name = "email" />',esc_attr($commenter['comment_author_email']))
		)

	));
	?>
</section>