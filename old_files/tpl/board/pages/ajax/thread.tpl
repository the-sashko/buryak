<?php
	foreach($posts as $idx => $post):
		_part('post/card',0,[
			'post' => $post,
			'type' => 'thread'
		]);
	endforeach;
?>
<div id="last" data-id="<?=$threadMaxReplyID;?>"></div>