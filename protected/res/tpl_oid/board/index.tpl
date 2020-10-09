<?php
	if(!isset($ajaxTemplate)||!$ajaxTemplate):
		_part('header');
		if(!$isMainPage&&strlen($pageTitle)>0):
?>
			<h1 class="main_title"><?=$pageTitle;?></h1>
<?php
		endif;
	endif;
	_page($template);
	if(!isset($ajaxTemplate)||!$ajaxTemplate):
		_part('footer');
	endif;
?>