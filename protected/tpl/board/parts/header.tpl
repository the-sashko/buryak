<!DOCTYPE html>
<html class="no-js">
<head>
	<title>The site</title>
	<?php _part('meta'); ?>
	<?php _part('css'); ?>
</head>
<body>
	<div class="scroll_down"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
	<div class="header_background"></div>
	<div class="wrapper">
		<header class="row fullWidth header">
			<div class="large-3 medium-3 small-6 columns logo">
				<img src="/assets/img/logo.png"><span>The Site</span>
			</div>
			<?php _part('menu/top'); ?>
		</header>
		<main class="row fullWidth main">
			<?php _part('menu/sidebar'); ?>
			<div class="large-9 medium-9 small-12 columns content">
				<?php _part('menu/sections'); ?>