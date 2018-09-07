<!DOCTYPE html>
<html class="no-js">
<head>
	<?php if(isset($isMainPage)&&$isMainPage): ?>
	<title><?=$sitename;?> - Main page</title>
	<?php else: ?>
	<title><?php foreach(array_reverse($URLPath) as $URLPathItem): ?><?=$URLPathItem['title'];?> / <?php endforeach; ?><?=$sitename;?></title>
	<?php endif; ?>
	<?php _part('meta'); ?>
	<?php _part('css'); ?>
</head>
<body>
	<div class="scroll_down"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
	<div class="header_background"></div>
	<div class="wrapper">
		<header class="row fullWidth header">
			<?php if($isMainPage): ?>
			<h1 class="large-3 medium-3 small-6 columns logo">
				<img src="/assets/img/logo.png"><span><?=$sitename;?></span>
			</h1>
			<?php else: ?>
			<div class="large-3 medium-3 small-6 columns logo">
				<a href="/"><img src="/assets/img/logo.png" alt="site logo"><span><?=$sitename;?></span></a>
			</div>
			<?php endif; ?>
			<?php _part('menu/top'); ?>
		</header>
		<main class="row fullWidth main">
			<?php _part('menu/sidebar'); ?>
			<div class="large-9 medium-9 small-12 columns content">
				<?php _part('menu/sections'); ?>