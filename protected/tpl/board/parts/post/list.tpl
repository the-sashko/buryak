<?php
	if(isset($posts)&&is_array($posts)):
		foreach($posts as $post):
			_part('post/card',0,[
				'post' => $post,
				'type' => 'section'
			]);
		endforeach;
	endif;
?>