<?php
	$type = isset($type)&&strlen($type)?$type:'default';
?>
<article class="post_card">
	<i class="fa fa-chevron-down post_options_btn" data-postid="" aria-hidden="true"></i>
	<div class="post_metadata">
		<?php
			if(
				$type != 'single' &&
				$type != 'section' &&
				$type != 'thread'
			):
		?>
		<div class="post-parent">
			Board: <strong>/<?=$section['name'];?>/</strong> Thread: <strong><?=$post['title'];?></strong>
		</div>
		<?php
			endif;
		?>
		<span class="post_id">#<?=$post['relative_id'];?></span><?php if(strlen($post['title'])>0): ?>&nbsp;<span class="post_title"><a href="/<?=$section['name'];?>/<?=$post['relative_id'];?>/"><?=$post['title'];?></a></span><?php endif; ?>
		<span class="post_time"><?=$post['created'];?></span>&nbsp;<span class="post_author"><?=$post['username'];?></span><?php if(strlen($post['tripcode'])>0): ?><span class="post_tripcode"><?=$post['tripcode'];?></span><?php endif; ?>
	</div>
	<div class="post_content">
		<p><?php _part('post/media'); ?><?=$post['text'];?></p>
	</div>
	<?php
		if(
			$type != 'single' &&
			$type != 'thread'
		):
	?>
	<a href="/<?=$section['name'];?>/<?=$post['relative_id'];?>/" class="button">Go to thread<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left:0.5em"></i></a>
	<?php if(isset($post['count_hidden_posts'])&&$post['count_hidden_posts']>0): ?><span><a href="/<?=$section['name'];?>/<?=$post['relative_id'];?>/"><?=$post['count_hidden_posts'];?> messages hidden</a></span><?php endif;?>
	<?php
		endif;
	?>
</article>
<br>