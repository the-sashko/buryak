<?php _part('header'); ?>
<?php if(!$isMainPage&&strlen($pageTitle)>0): ?>
<h1 class="main_title"><?=$pageTitle;?></h1>
<?php endif; ?>
<?php _page($template); ?>
<?php _part('footer'); ?>