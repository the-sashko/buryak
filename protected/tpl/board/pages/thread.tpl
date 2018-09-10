<?php
	_part('post/form');
	_part('post/card',0,[
		'post' => $originalPost,
		'type' => 'thread'
	]);
	_part('post/list');
?>