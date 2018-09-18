<div class="post_form">
	<?php
		if(isset($postFormError)&&is_array($postFormError)&&count($postFormError)>0):
	?>
		<ul class="form_error">
			<?php foreach($postFormError as $postFormErrorItem): ?>
			<li><?=$postFormErrorItem;?></li>
			<?php endforeach; ?>
		</ul>
		<form method="POST" enctype="multipart/form-data" action="/write/" class="post_form_visible">
	<?php
		else:
	?>
		<a href="#" class="open_form_btn">Write</a>
		<form method="POST" enctype="multipart/form-data" action="/write/" class="post_form_hidden">
	<?php
		endif;
	?>
		<input type="hidden" name="section_id" value="<?=$section['id'];?>">
		<input type="hidden" name="thread_id" value="<?=isset($threadID)&&intval($threadID)>0?$threadID:'-1';?>">
		<input type="file" name="media">
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<input type="text" name="title" placeholder="Title" class="large-12 medium-12 small-12 columns post_form_title">
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-5 medium-6 small-12 columns">
				<div class="button" onclick=""><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Download file</div>
			</div>
			<div class="large-7 medium-6 small-12 columns">
				<input type="checkbox" name="no_media" value="on" class="form_checkbox"><span class="form_checkbox_label">&nbsp;Without&nbsp;file</span>
				<div class="clear"></div>
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-4 medium-4 small-12 columns">
				<input type="text" name="name" placeholder="Name">
			</div>
			<div class="large-4 medium-4 small-12 columns">
				<input type="password" name="psswd" placeholder="Password" class="large-7 medium-6 small-12 columns">
			</div>
			<div class="large-4 medium-4 small-12 columns">
				<input type="checkbox" name="trip_code" value="on" class="form_checkbox"><span class="form_checkbox_label">&nbsp;Tripcode</span>
				<div class="clear"></div>
			</div>
		</div>	
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns editor_buttons">
				<a href="#" data-action="bold" class="button"><strong>b</strong></a><a href="#" data-action="italic" class="button"><em>i</em></a><a href="#" data-action="strike" class="button"><del>s</del></a><a href="#" data-action="spoiler" class="button">Spoiler</a><a href="#" data-action="link" class="button">Link</a>
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<textarea name="text" placeholder="Text"></textarea>
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-6 medium-6 small-12 columns">
				<img src="https://fajno.in/1504688137/captcha.png" id="captcha-image">
				<a href="#" id="reload-captcha">Other image</a>
				<input type="text" name="captcha" placeholder="Enter words form picture" id="captcha">
			</div>
			<div class="large-6 medium-6 small-12 columns">
				<input type="radio" name="after" value="go2thread" checked="" class="form_radio"><span class="form_radio_label">&nbsp;Go&nbsp;to&nbsp;thread&nbsp;</span>
				<input type="radio" name="after" value="go2section" class="form_radio"><span class="form_radio_label">&nbsp;Go&nbsp;to&nbsp;board&nbsp;</span>
				<div class="clear"></div>
				<input type="submit" value="Send" class="button">
			</div>
		</div>
	</form>
</div>