<?php
	if(isset($post)):
		_part('post/card',0,[
			'post' => $post,
			'type' => 'section'
		]);
	endif;
?>