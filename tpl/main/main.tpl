{{define "Data"}}
<!DOCTYPE html>
<html class="no-js">
<head>
	<title>test</title>
	<link rel="stylesheet" href="/assets/css/lib/foundation.min.css" media="screen">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>
<body>
	<style>
		* {
			margin: 0;
			padding: 0;
			font-family:'Open Sans',Arial,sans-serif;
		}
		html, body {
			height: 100%;
			font-size: 16px;
		}
		body{
			background: #F8F8EC;
			color: #333;
			text-align: justify;
			min-width: 200px;
		}
		#header{
			background-color: #F42;
			color: #FEFEFE;
			height: 40px;
			box-shadow: 0 2px 5px #DADBDD;
			padding: 0;
		}
		#header-background {
			height: 39px;
			background: #F42;
			box-shadow: 0 2px 5px #DADBDD;
			width: 100%;
			position: absolute;
			content: "";
			top: 0;
			right: 0;
		}
		.top-menu {
			text-align: right;
		}
		.top-menu a{
			color: #FFF;
		}
		#logo {
			/*display: inline-block;*/
			font-weight: 900;
			text-transform: uppercase;
			font-size: 1.5em;
			/*line-height: 1.75em;*/
			/*float: left;*/
			/*padding: 0 0.5em 0 0;*/
			cursor: pointer;
			margin: 0;
		}
		#logo img {
			padding: 0;
			border: 0;
			width: 30px;
			height: 30px;
			margin: 0;
		}
		#wrapper {
			position: relative;
			min-height: 100%;
			margin: 0 auto;
			overflow: hidden;
			max-width: 1200px;
		}
		#main-title{
			width: auto;
			padding-left: 25%;
			width: 100%;
			text-align: center;
			color: #555;
			font-size: 1.25em;
			line-height: 1.25em;
			padding: 0 0 0.75em 0;
		}
		#footer{
			background-color: #333;
			color: #FEFEFE;
			font-size: 1em;
			font-weight: bold;
			width: 100%;
			height: 60px;
			box-shadow: 0 2px 5px #DADBDD;
			position: absolute;
			bottom: 0;
			left: 0;
		}
		#footer-background {
			width: 100%;
			height: 60px;
			background: #3A3A3A;
			margin-top: -60px;
			box-shadow: 0 -2px 5px #DADBDD;
		}
		#sidebar {
			font-size: 1.0625em;
			font-weight: bold;
		}
		#sidebar a{
			display: block;
			margin-bottom: 0.125em;
		}
		.sidebar-item-title{
			color: #6A6A6A;
		}
		.sidebar-item-age {
			color: #EE6A6A;
		}
		.sidebar-item-unread {
			background: #6A6A6A;
			color: #FEFEFE;
			font-size: 0.625em;
			padding: 0.25em 0.5em;
			border-radius: 0.25em;
			margin-bottom: 0.125em;
			/*display: inline-block;*/
		}
	</style>
	<div id="header-background"></div>
	<div id="wrapper">
		<header class="row fullWidth" id="header">
			<div id="logo" class="large-3 medium-3 small-6 columns">
				<img src="/assets/img/logo.png"><span>Файно</span>
			</div>
			<nav class="large-9 medium-9 small-6 columns hide-for-small-only top-menu">
				<a href="/page/about/">Ебаут</a>
				<a href="/page/rules/">Правила</a>
				<a href="/page/feedback/">Зв'язок</a>
				<a href="/search/">Пошук</a>
			</nav>
			<div class="small-6 columns top-menu show-for-small-only" id="top-menu-button"><a href="#">Меню</a></div> <div class="clear"></div>
		</header>
		<main class="row fullWidth" id="main">
			<h1 id="main-title">Зв'язок</h1>
			<div id="sidebar" class="large-3 medium-3 small-12 column hide-for-small-only">
				<aside>
					<nav>
						<div class="hide-for-medium-only">
							<a href="/b/"><span class="sidebar-item-title">Безглуздя</span>&nbsp;<span class="sidebar-item-age">18+</span></a>
							<a href="/p/"><span class="sidebar-item-title">АдмінIстраWіяdдHі</span>&nbsp;<span class="sidebar-item-age">18+</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
							<a href="/lit/"><span class="sidebar-item-title">Література</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
							<a href="/ff/"><span class="sidebar-item-title">Фантастика</span>&nbsp;<span class="sidebar-item-unread">12</span></a>
							<a href="/wh/"><span class="sidebar-item-title">WarHammer</span></a>
							<a href="/adm/"><span class="sidebar-item-title">Адміністрація</span></a>
							<a href="/int/"><span class="sidebar-item-title">International</span></a>
							<a href="/trash/"><span class="sidebar-item-title">Смітник</span></a>
							<a href="/mov/"><span class="sidebar-item-title">Кінематограф</span></a>
							<a href="/all/"><span class="sidebar-item-title">Всі повідомлення</span></a>
						</div>
						<div class="show-for-medium-only">
							<a href="/b/"><span class="sidebar-item-title">/b/</span>&nbsp;<span class="sidebar-item-age">18+</span></a>
							<a href="/p/"><span class="sidebar-item-title">/wtfwt/</span>&nbsp;<span class="sidebar-item-age">18+</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
							<a href="/lit/"><span class="sidebar-item-title">/lit/</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
							<a href="/ff/"><span class="sidebar-item-title">/ff/</span>&nbsp;<span class="sidebar-item-unread">12</span></a>
							<a href="/wh/"><span class="sidebar-item-title">/wh/</span></a>
							<a href="/adm/"><span class="sidebar-item-title">/adm/</span></a>
							<a href="/int/"><span class="sidebar-item-title">/int/</span></a>
							<a href="/trash/"><span class="sidebar-item-title">/tresh/</span></a>
							<a href="/mov/"><span class="sidebar-item-title">/mov/</span></a>
							<a href="/all/"><span class="sidebar-item-title">/all/</span></a>
						</div>
					</nav>
				</aside>
			</div>
			<div id="content" class="large-9 medium-9 small-12 columns">
				<div id="static-page-content">
                    <p>{{.Content}}</p>
				</div>
			</div>
			<div class="clear"></div>
		</main>


		<footer class="row fullWidth" id="footer">
			<div class="large-2 medium-4 small-12 columns"><a href="https://hit.ua/site_audit/102243" rel="nofollow" alt="hit.ua" title="Статистика">©&nbsp;Файно&nbsp;2016-2017</a></div>
			<div class="large-10 medium-8 columns hide-for-small-only">17935 повідомлень, 16 — сьогодні</div>
		</footer>
	</div>
	<div id="footer-background"></div>
	<script src="/assets/js/lib/jquery.min.js"></script>
	<script src="/assets/js/lib/foundation.min.js"></script>
	<script src="/assets/js/app.js"></script>
</body>
</html>
{{end}}