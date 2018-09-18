<?php
	if(isset($description)&&strlen($description)>0):
?>
<h3 class="main_subtitle"><?=$description;?></h3>
<?php
	endif;
	if($isAllSections):
		_part('filter');
	else:
		_part('post/form');
	endif;
	if(!count($posts)>0):
?>
	<div class="text-center">There are no posts here...</div>
<?php
	else:
		_part('post/list');
	endif;
?>