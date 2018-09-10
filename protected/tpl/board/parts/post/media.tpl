<?php
	if($post['media_type_id']!=1):
?>
<span class="post_media">
	<?php
		if((
			$post['media_type_id'] == 2 ||
			$post['media_type_id'] == 3 ||
			$post['media_type_id'] == 4) &&
			strlen($post['media_path'])>0
		):
	?>
	<a href="<?=$mediaBaseURL;?>/<?=$post['media_path'];?>">
	<?php
		elseif(
			$post['media_type_id'] == 5 &&
			strlen($post['media_path'])>0
		):
	?>
	<a href="<?=$post['media_path'];?>">
	<?php
		else:
	?>
	<a href="#">
	<?php
		endif;
	?>
		<?php
			if(strlen($post['media_tag'])>0):
		?>
		<span class="media_tag"><?=$post['media_tag'];?></span>
		<?php
			endif;
		?>
		<?php
			if(strlen($post['media_name'])>0):
		?>
		<span class="post_filename">File: <?=$post['media_name'];?></span>
		<?php
			endif;
		?>
		<?php
			if(
				isset($post['media_path_preview']) &&
				strlen($post['media_path_preview'])>0
			):
		?>
		<img src="<?=$mediaBaseURL;?>/<?=$post['media_path_preview'];?>">
		<?php
			endif;
		?>
	</a>
	<?php
		if((
			$post['media_type_id'] == 2 ||
			$post['media_type_id'] == 3 ||
			$post['media_type_id'] == 4) &&
			strlen($post['media_path'])>0
		):
	?>
	<a href="<?=$mediaBaseURL;?>/<?=$post['media_path'];?>" target="_blank" class="media_open">Open in new window</a>
	<?php
		elseif(
			$post['media_type_id'] == 5 &&
			strlen($post['media_path'])>0
		):
	?>
	<a href="<?=$post['media_path'];?>" target="_blank" class="media_open">Open in new window</a>
	<?php
		else:
	?>
	<a href="#" target="_blank" class="media_open">Open in new window</a>
	<?php
		endif;
	?>
</span>
<?php
	endif;
?>