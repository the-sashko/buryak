<?php if(isset($succ)&&$succ&&isset($successMessage)&&strlen($successMessage)>0): ?>
	<div class="succ_msg">
		<?=$successMessage;?><br>
	</div>
<?php endif; ?>
<?php if(isset($infoMessage)&&strlen($infoMessage)>0): ?>
	<div class="info_msg">
		<?=$infoMessage;?><br>
	</div>
<?php endif; ?>
<?php if(isset($err)&&count($err)>0): ?>
	<div class="err_msg">
	<?php foreach($err as $errMsg): ?>
		<?=$errMsg;?><br>
	<?php endforeach; ?>
	</div>
<?php endif; ?>