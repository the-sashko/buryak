<?php
	_part('post/form');
	if(!count($posts)>0):
?>
	<div class="text-center">There are no posts here...</div>
<?php
	else:
		_part('post/list');
	endif;
?>