<?php
	$type = isset($type)&&strlen($type)?$type:'default';
	$postURL = "/{$post['section_name']}/{$post['relative_id']}/";
?>
<article id="post_<?=$post['id'];?>" class="post_card" data-postID="<?=$post['id'];?>" data-postRelID="<?=$post['relative_id'];?>">
	<i class="fa fa-chevron-down post_options_btn" aria-hidden="true"></i>
	<div class="post_metadata">
		<?php
			if(
				$type != 'single' &&
				$type != 'section' &&
				$type != 'thread'
			):
		?>
		<div class="post-parent">
			Board: <strong>/<?=$post['section_name'];?>/</strong> Thread: <strong><?=$post['title'];?></strong>
		</div>
		<?php
			endif;
		?>
		<a href="<?=$postURL;?>" class="post_id">#<?=$post['relative_id'];?></a><?php if(strlen($post['title'])>0): ?>&nbsp;<span class="post_title"><a href="<?=$postURL;?>"><?=$post['title'];?></a></span><?php endif; ?>
		<span class="post_time"><?=$post['created'];?></span>&nbsp;<span class="post_author"><?=$post['username'];?></span><?php if(strlen($post['tripcode'])>0): ?><span class="post_tripcode"><?=$post['tripcode'];?></span><?php endif; ?>
	</div>
	<div id="post_content_<?=$post['id'];?>" class="post_content" data-id="<?=$post['id'];?>">
		<p><?php _part('post/media'); ?><?=$post['text'];?></p>
	</div>
	<div id="post_additional_actions_<?=$post['id'];?>" class="post_additional_actions" data-id="<?=$post['id'];?>"></div>
	<?php
		if(isset($post['webLink'])&&is_array($post['webLink'])&&count($post['webLink'])>0&&strlen(trim($post['webLink']['description']))>0):
	?>
	<div id="post_link_<?=$post['id'];?>" class="post_link">
		<a href="<?=$post['webLink']['URL'];?>" rel="nofollow" target="_blank">
			<div style="
				background-image: url('<?=$post['webLink']['image'];?>');
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				background-color: #FEFEFE;
			" class="post_link_image"></div>
			<div class="post_link_title"><?=$post['webLink']['title'];?></div>
			<div class="post_link_description"><?=$post['webLink']['description'];?></div>
			<div class="clear"></div>
		</a>
	</div>
	<?php
		endif;
	?>
	<?php
		if(
			$type != 'single' &&
			$type != 'thread'
		):
	?>
	<a href="<?=$postURL;?>" class="button">Go to thread<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left:0.5em"></i></a>
	<?php if(isset($post['count_hidden_posts'])&&$post['count_hidden_posts']>0): ?><span><a href="<?=$postURL;?>"><?=$post['count_hidden_posts'];?> messages hidden</a></span><?php endif;?>
	<?php
		endif;
	?>
</article>
<br>