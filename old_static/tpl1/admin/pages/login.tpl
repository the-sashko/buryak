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