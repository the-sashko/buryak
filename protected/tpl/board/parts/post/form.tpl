				<div class="post_form">
					<form method="POST" enctype="multipart/form-data" action="/write/">
						<div class="row fullWidth form_input_row">
							<input type="text" name="title" placeholder="Заголовок" class="large-12 medium-12 small-12 columns post_form_title">
						</div>
						<div class="row fullWidth form_input_row">
							<div class="large-5 medium-6 small-12 columns">
								<div class="button"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Завантажити файл</div>
								<input type="file" name="media">
							</div>
							<div class="large-7 medium-6 small-12 columns">
								<input type="checkbox" name="no-media">&nbsp;Без&nbsp;медіафайлу
							</div>
						</div>
						<div class="row fullWidth form_input_row">
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
						<div class="row fullWidth form_input_row">
							<div  class="large-12 medium-12 small-12 columns">
								<a href="#" data-action="bold" class="button"><strong>b</strong></a><a href="#" data-action="italic" class="button"><em>i</em></a><a href="#" data-action="strike" class="button"><del>s</del></a><a href="#" data-action="spoiler" class="button">Прихований</a>
							</div>
						</div>
						<div class="row fullWidth form_input_row">
							<div  class="large-12 medium-12 small-12 columns">
								<textarea name="text" placeholder="Текст"></textarea>
							</div>
						</div>
						<input type="hidden" name="threadID" value="0">
						<input type="hidden" name="section" value="b">
						<div class="row fullWidth form_input_row">
							<div class="large-12 medium-12 small-12 columns">
								<img src="https://fajno.in/1504688137/captcha.png" id="captcha-image">
								<a href="#" id="reload-captcha">Інше зображення</a>
							</div>
							<div  class="large-12 medium-12 small-12 columns">
								<input type="text" name="captcha" placeholder="Введіть слова з картинки" id="captcha">
							</div>
						</div>
						<div class="row fullWidth form_input_row">
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