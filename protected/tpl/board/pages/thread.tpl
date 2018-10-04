<?php
	_part('post/form');
	_part('post/card',0,[
		'post' => $originalPost,
		'type' => 'thread'
	]);
	foreach($posts as $post):
		_part('post/card',0,[
			'post' => $post,
			'type' => 'thread'
		]);
	endforeach;
?>