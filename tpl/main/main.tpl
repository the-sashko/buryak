{{define "Data"}}
<!DOCTYPE html>
<html class="no-js">
<head>
	<title>test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="stylesheet" href="/assets/css/lib/foundation.min.css" media="screen">
	<link rel="stylesheet" href="/assets/css/lib/font-awesome.min.css" media="screen">
	<link rel="stylesheet" href="/assets/css/app.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>
<body>
	<div id="scroll-down"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
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
			<div class="small-6 columns top-menu show-for-small-only" id="top-menu-button"><a href="#">Меню</a></div> 
		</header>
		<main class="row fullWidth" id="main">
			<div id="sidebar" class="large-3 medium-3 small-12 column hide-for-small-only">
				<aside>
					<nav>
						<div class="hide-for-medium-only">
							<a href="/b/"><span class="sidebar-item-title">Безглуздя</span>&nbsp;<span class="age-restriction">18+</span></a>
							<a href="/p/"><span class="sidebar-item-title">АдмінIстраWіяdдHі</span>&nbsp;<span class="age-restriction">18+</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
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
							<a href="/b/"><span class="sidebar-item-title">/b/</span>&nbsp;<span class="age-restriction">18+</span></a>
							<a href="/p/"><span class="sidebar-item-title">/wtfwt/</span>&nbsp;<span class="age-restriction">18+</span>&nbsp;<span class="sidebar-item-unread">99+</span></a>
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
			<div id="content" class="large-9 medium-9 small-12 columns"><!--class="large-12 medium-12 small-12 columns">-->
				<!--<div id="static-page-content">
                    <p>{{.Content}}</p>
				</div>-->
				<div id="main-section-list" class="hide-for-small-only">
					<div class="row fullWidth">
						<h2 id="full-board-list-title" class="large-12 medium-12 small-12 columns">Розділи</h2>
					</div>
					<nav class="row fullWidth">
						<ul class="large-6 medium-6 small-6 columns">
							<li>
								<a href="/p/">/wtfwt/&nbsp;<span>АдмінIстраWіяdдHі</span>&nbsp;<span class="age-restriction">18+</span>&nbsp;‐&nbsp;Суспільно-політична тематика</a>
							</li>
							<li>
								<a href="/p/">/p/&nbsp;<span>Політика</span>&nbsp;‐&nbsp;Суспільно-політична тематика</a>
							</li>
							<li>
								<a href="/lit/">/lit/&nbsp;<span>Література</span>&nbsp;‐&nbsp;Хата-читальня</a>
							</li>
							<li>
								<a href="/ff/">/ff/&nbsp;<span>Фантастика</span>&nbsp;‐&nbsp;фантастика і фентезі</a>
							</li>
							<li>
								<a href="/all/">/all/&nbsp;<span>Всі</span>&nbsp;‐&nbsp;Всі повідомлення</a>
							</li>
						</ul>
						<ul class="large-6 medium-6 small-6 columns">
							<li>
								<a href="/wh/">/wh/&nbsp;<span>WarHammer</span>&nbsp;‐&nbsp;WarHammer</a>
							</li>
							<li>
								<a href="/adm/">/adm/&nbsp;<span>Адміністрація</span>&nbsp;‐&nbsp;Відгуки, пропозції, робота сайту</a>
							</li>
							<li>
								<a href="/int/">/int/&nbsp;<span>International</span>&nbsp;‐&nbsp;Міжнародний розділ</a>
							</li>
							<li>
								<a href="/trash/">/trash/&nbsp;<span>Смітник</span>&nbsp;‐&nbsp;Срачі, оффтоп та інший непотріб</a>
							</li>
							<li>
								<a href="/mov/">/mov/&nbsp;<span>Кінематограф</span>&nbsp;‐&nbsp;Фільми та серіали</a>
							</li>
						</ul>
					</nav>
					<div id="mouse-icon">
						<div id="mouse-icon-wheel">&nbsp;</div>
					</div>
				</div>
				<h1 id="main-title">Зв'язок</h1>
				<div id="post-form">
					<form method="POST" action="/write/"> <!-- enctype="multipart/form-data" -->
						<div class="row fullWidth form-input-row">
							<input type="text" name="title" placeholder="Заголовок" id="post-form-title" class="large-12 medium-12 small-12 columns">
						</div>
						<div class="row fullWidth form-input-row">
							<div class="large-5 medium-6 small-12 columns">
								<div id="post-form-media-btn" class="button"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Завантажити файл</div>
								<input type="file" name="media" id="post-form-media">
							</div>
							<div class="large-7 medium-6 small-12 columns">
								<input type="checkbox" name="no-media">&nbsp;Без&nbsp;медіафайлу
							</div>
						</div>
						<div class="row fullWidth form-input-row">
							<div  class="large-4 medium-4 small-12 columns">
								<input type="text" name="name" placeholder="Ім'я">
							</div>
							<div  class="large-4 medium-4 small-12 columns">
								<input type="password" name="psswd" placeholder="Пароль" class="large-7 medium-6 small-12 columns">
							</div>
							<div class="large-4 medium-4 small-12 columns">
								<input type="checkbox" name="trip-code">&nbsp;Тріпкод
							</div>
						</div>	
						<div class="row fullWidth form-input-row">
							<div  class="large-12 medium-12 small-12 columns" id="post-form-edit-buttons">
								<a href="#" data-action="bold" class="button"><strong>b</strong></a><a href="#" data-action="italic" class="button"><em>i</em></a><a href="#" data-action="strike" class="button"><del>s</del></a><a href="#" data-action="spoiler" class="button">Прихований</a>
							</div>
						</div>
						<div class="row fullWidth form-input-row">
							<div  class="large-12 medium-12 small-12 columns">
								<textarea name="text" placeholder="Текст" id="post-form-text"></textarea>
							</div>
						</div>
						<input type="hidden" name="threadID" value="0">
						<input type="hidden" name="section" value="b">
						<input type="hidden" name="token" value="70K3n">
						<div class="row fullWidth form-input-row">
							<div  class="large-12 medium-12 small-12 columns">
								<img src="https://fajno.in/1504688137/captcha.png" id="captcha-image">
								<a href="#" id="reload-captcha">Інше зображення</a>
							</div>
							<div  class="large-12 medium-12 small-12 columns">
								<input type="text" name="captcha" placeholder="Введіть слова з картинки" id="captcha">
							</div>
						</div>
						<div class="row fullWidth form-input-row">
							<div  class="large-12 medium-12 small-12 columns">
								<input type="radio" name="after" value="go2thread" checked="">&nbsp;До&nbsp;теми
								<input type="radio" name="after" value="go2section">&nbsp;До&nbsp;розділу
							</div>
							<div  class="large-12 medium-12 small-12 columns">
								<input type="submit" value="Написати" class="button">
							</div>
						</div>
					</form>
				</div>
				<article class="post-card">
					<i class="fa fa-chevron-down post-options-btn" data-postid="" aria-hidden="true"></i>
					<div class="post-metadata">
						<div class="post-parent">
							Дошка: <strong>/p/</strong> Нитка: <strong>Нитка така нитка</strong>
						</div>
						<span class="post-id">#195</span>&nbsp;<span class="post-title"><a href="#">Тема така тема</a></span>
						<span class="post-time">16:09:12&nbsp;20.09.2016</span>&nbsp;<span class="post-author">Anonymous</span><span class="post-tripcode">!cvFgytFc9m</span>
					</div>
					<div class="post-content">
						<p class="last-p"><span class="post-media">
							<a href="#">
								<span class="media-tag">gif</span>
								<span class="post-filename">Файл: igor_vinskiy.jpg</span>
								<img src="https://peekswebware.files.wordpress.com/2015/12/8a168-12338852_1713276842235926_1926181089_n.jpg">
							</a>
							<a href="#" target="_blank" class="media-open">Відкрити в новому вікні</a>
						</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec ante pharetra neque sodales lacinia. Vestibulum euismod ligula quis mollis ultricies. In facilisis nec lorem eget consequat. Nulla facilisi. In ut pulvinar tellus. Maecenas eu libero vel dolor scelerisque lobortis. Morbi tristique quam ac risus egestas, sit amet laoreet eros tincidunt. Pellentesque eget sollicitudin lacus.</p>
					</div>
					<a href="#" class="button">Перейти до нитки<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left:0.5em"></i></a>					
					<span><a href="#">500 повідомлень приховано</a></span>
				</article>
				<div class="related-posts">
					<article class="post-card">
						<i class="fa fa-chevron-down post-options-btn" data-postid="" aria-hidden="true"></i>
						<div class="post-metadata">
						<div class="post-parent">
							Дошка: <strong>/p/</strong> Нитка: <strong>Нитка така нитка</strong>
						</div>
						<span class="post-id">#195</span>&nbsp;<span class="post-title"><a href="#"></a></span>
						<span class="post-time">16:09:12&nbsp;20.09.2016</span>&nbsp;<span class="post-author">Anonymous</span>
					</div>
					<div class="post-content">
						<p class="last-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec ante pharetra neque sodales lacinia. Vestibulum euismod ligula quis mollis ultricies. In facilisis nec lorem eget consequat. Nulla facilisi. In ut pulvinar tellus. Maecenas eu libero vel dolor scelerisque lobortis. Morbi tristique quam ac risus egestas, sit amet laoreet eros tincidunt. Pellentesque eget sollicitudin lacus.</p>
					</div>
						<a href="#" class="button">Перейти до нитки<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left:0.5em"></i></a>					
					</article>
					<article class="post-card">
					<i class="fa fa-chevron-down post-options-btn" data-postid="" aria-hidden="true"></i>
					<div class="post-metadata">
						<div class="post-parent">
							Дошка: <strong>/p/</strong> Нитка: <strong>Нитка така нитка</strong>
						</div>
						<span class="post-id">#195</span>&nbsp;<span class="post-title"><a href="#">Тема така тема</a></span>
						<span class="post-time">16:09:12&nbsp;20.09.2016</span>&nbsp;<span class="post-author">Anonymous</span>
					</div>
					<div class="post-content">
						<p class="last-p"><span class="post-media">
							<a href="#">
								<span class="media-tag">gif</span>
								<span class="post-filename">Файл: test.jpg</span>
								<img src="https://peekswebware.files.wordpress.com/2015/12/8a168-12338852_1713276842235926_1926181089_n.jpg">
							</a>
							<a href="#" target="_blank" class="media-open">Відкрити в новому вікні</a>
						</span></p>
					</div>
					<a href="#" class="button">Перейти до нитки<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left:0.5em"></i></a>
					</article>
				</div>
			</div>			
		</main>
		<footer class="row fullWidth" id="footer">
			<div class="large-3 medium-4 small-12 columns"><a href="https://hit.ua/site_audit/102243" rel="nofollow" alt="hit.ua" title="Статистика">©&nbsp;Файно&nbsp;2016-2017</a></div>
			<div class="large-9 medium-8 columns hide-for-small-only"><a href="#">17935 повідомлень, 16 — сьогодні</a></div>
		</footer>
	</div>
	<div id="footer-background"></div>
	<div id="scroll-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>
	<script src="/assets/js/lib/jquery.min.js"></script>
	<script src="/assets/js/lib/foundation.min.js"></script>
	<script src="/assets/js/app.js"></script>
</body>
</html>
{{end}}