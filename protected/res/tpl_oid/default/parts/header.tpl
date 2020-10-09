<!DOCTYPE html>
<html>
<head>
    <title><?=$meta['title'];?></title>
    <meta charset="utf-8" />
    <?php
        _part('meta');
        _part('css');
    ?>
</head>
<body>
<div class="header-wrapper"></div>
<div class="wrapper">
    <div class="header">
        <div class="site-title-wrapper">
            <h1 class="site-title"><?=$meta['site_name'];?></h1>
            <div class="site-subtitle"><?=$meta['site_slogan'];?></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="content">
        <?=$breadcrumbs;?>
