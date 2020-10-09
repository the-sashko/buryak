<?php _part('header'); ?>
<?php if(!isset($purePage)): ?>
<header class="header">
	<h1>Admin area</h1>
</header>
<?php endif; ?>
<div class="wrapper">
<?php if(!isset($purePage)): ?>
	<?php _part('menu'); ?>
	<main class="main">
<?php else: ?>
	<main class="main pure_page">
<?php endif;?>
		<?php _part('alert'); ?>
		<?php _page($template); ?>
	</main>
	<div class="clear"></div>
</div>
<?php _part('footer'); ?>