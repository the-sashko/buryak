<!DOCTYPE html>
<html>
<head>
	<title>Admin area</title>
</head>
<body>
	<?php if(!isset($purePage)): ?>
	<header class="header">
		<h1>Admin area</h1>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</header>
	<?php endif; ?>
	<div class="wrapper">
		<?php if(!isset($purePage)): ?>
		<nav class="menu">
			<a href="/admin/posts">Posts</a>
			<a href="/admin/spam/">Anti-spam</a>
			<a href="/admin/ban/">Ban</a>
			<a href="/admin/sections/">Sections</a>
			<a href="/admin/settings/">Settings</a>
			<a href="/admin/users/">Users</a>
			<a href="/admin/logout/">Logout</a>
		</nav>
		<main class="main">
		<?php else: ?>
		<main class="main pure_page">
		<?php endif;?>
			<!--<div class="succ_msg">
				Success!<br>line1<br>line1<br>line1<br>
			</div>
			<div class="info_msg">
				Info!<br>line1<br>line1<br>line1<br>
			</div>-->
			<?php if(isset($err)&&count($err)>0): ?>
			<div class="err_msg">
				<?php foreach($err as $errMsg): ?>
				<?=$errMsg;?><br>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<form action="/<?=$scope;?>/login/" method="post" class="login_form">
				<p>
					<input type="text" name="email" placeholder="email" class="login_input" value="<?=isset($formData['email'])?$formData['email']:'';?>">
				</p>
				<p>
					<input type="password" name="pswd" placeholder="password" class="login_input" value="<?=isset($formData['pswd'])?$formData['pswd']:'';?>">
				</p>
				<p>
					<input type="submit" value="login" class="form_btn login_form_btn">
				</p>
			</form>
		</main>
		<div class="clear"></div>
	</div>
</body>
<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}
	body {
		font-family: Arial,sans-serif;
		font-size: 16px;
		color:#333;
		background:#FEFEFE;
		min-width:320px;
	}
	input {
    	font-size: 1.125em;
    	padding: .125em .25em;
    	border: 1px solid #6A6A6A;
    	border-radius: .125em;
		min-width: 300px;
	}
	form{
		text-align: center;
	}
	p {
		margin-bottom: .5em;
	}
	.header {
		width:100%;
		background: #48A;
	}
	.header h1 {
		text-align: center;
		font-size: 1.25em;
		font-weight: bold;
		color: #FEFEFE;
		text-transform: uppercase;
		padding: .25em 0;
	}
	.clear{
		content:"";
		display:block;
		clear:both
	}
	.menu {
		background: #333;
		padding: .5em;
		text-align: center;
	}
	.menu a{
		text-decoration: none;
		color: #FEFEFE;
		font-weight: bold;
		text-transform: uppercase;
		margin: 0 .25em;
	}
	.menu a:hover{
		color: #A42;
	}
	.menu a:active{
		color: #A42;
	}
	.main {
		padding: .5em;
	}
	.form_btn{
		background: #48F;
		border: 1px solid #248;
		color: #FEFEFE;
		text-transform: uppercase;
		padding-top: .25em;
		font-weight: bold;
		min-width: 311px;
	}
	.login_input{
		max-width: 300px;
	}
	.login_form_btn{
		max-width: 311px;
	}
	.login_form{
		text-align: center;
	}
	.pure_page{
		width:100% !important;
	}
	@media(min-width:960px){
		body{
			background: #333;
		}
		input{
			width: 720px;
		}
		form{
			text-align: left;
		}
		.header{
			position: absolute;
			top: 0;
			right: 0;
			z-index: 1000;
		}
		.wrapper{
			padding-top:33px;
		}
		.menu{
			float: left;
			width: 15%;
		}
		.menu a {
			margin: 0 .25em .5em .25em;
			display: block;
			text-align: left;
		}
		.main {
			position: absolute;
			padding: 0 .5em .5em .5em;
			padding-top: 41px;
			width: 84%;
			top: 0;
			right: 0;
			background: #FEFEFE;
			min-height: 100%;
		}
		.succ_msg{
			background: #CFC;
			color: #040;
			padding: .5em;
			border: 1px solid #484;
			border-radius: .125em;
			font-size: 1.125em;
			font-weight: bold;
			line-height: 1.375em;
			margin-bottom: .5em;
		}
		.info_msg{
			background: #FFC;
			padding: .5em;
			border: 1px solid #884;
			border-radius: .125em;
			font-size: 1.125em;
			font-weight: bold;
			color: #440;
			line-height: 1.375em;
			margin-bottom: .5em;
		}
		.err_msg{
			background: #FCC;
			padding: .5em;
			border: 1px solid #844;
			border-radius: .125em;
			font-size: 1.125em;
			font-weight: bold;
			color: #400;
			line-height: 1.375em;
			margin-bottom: .5em;
		}
		.form_btn{
			width: 731px;
		}
	}
</style>
</html>