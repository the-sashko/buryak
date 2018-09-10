<div class="post_form">
	<?php
		if(isset($postFormError)&&is_array($postFormError)):
	?>
		<ul>
			<?php foreach($postFormError as $postFormErrorItem): ?>
			<li><?=$postFormErrorItem;?></li>
			<?php endforeach; ?>
		</ul>
	<?php
		endif;
	?>
	<form method="POST" enctype="multipart/form-data" action="/write/">
		<input type="hidden" name="section_id" value="<?=$section['id'];?>">
		<input type="hidden" name="thread_id" value="<?=isset($threadID)&&intval($threadID)>0?$threadID:'-1';?>">
		<div class="row fullWidth form_input_row">
			<input type="text" name="title" placeholder="Title" class="large-12 medium-12 small-12 columns post_form_title">
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-5 medium-6 small-12 columns">
				<div class="button" onclick=""><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Download file</div>
				<input type="file" name="media" style="display:block !important;">
			</div>
			<div class="large-7 medium-6 small-12 columns">
				<input type="checkbox" name="no_media" value="on">&nbsp;Without&nbsp;file
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
				<input type="checkbox" name="trip_code" value="on">&nbsp;Tripcode
			</div>
		</div>	
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<a href="#" data-action="bold" class="button"><strong>b</strong></a><a href="#" data-action="italic" class="button"><em>i</em></a><a href="#" data-action="strike" class="button"><del>s</del></a><a href="#" data-action="spoiler" class="button">Spoiler</a>
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<textarea name="text" placeholder="Text"></textarea>
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<img src="https://fajno.in/1504688137/captcha.png" id="captcha-image">
				<a href="#" id="reload-captcha">Other image</a>
			</div>
			<div class="large-12 medium-12 small-12 columns">
				<input type="text" name="captcha" placeholder="Enter words form picture" id="captcha">
			</div>
		</div>
		<div class="row fullWidth form_input_row">
			<div class="large-12 medium-12 small-12 columns">
				<input type="radio" name="after" value="go2thread" checked="">&nbsp;Go&nbsp;to&nbsp;thread
				<input type="radio" name="after" value="go2section">&nbsp;Go&nbsp;to&nbsp;board
			</div>
			<div class="large-12 medium-12 small-12 columns">
				<input type="submit" value="Send" class="button">
			</div>
		</div>
	</form>
</div>