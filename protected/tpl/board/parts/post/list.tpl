<?php
	if(isset($posts)&&is_array($posts)):
		foreach($posts as $post):
			_part('post/card',0,[
				'post' => $post,
				'type' => 'section'
			]);
			if(isset($post['recent_posts'])&&is_array($post['recent_posts'])&&count($post['recent_posts'])>0&&!(isset($isMainPage)&&$isMainPage)):
?>
	<div class="related_posts">
<?php
				foreach($post['recent_posts'] as $subpost):
					_part('post/card',0,[
						'post' => $subpost,
						'type' => 'section'
					]);
				endforeach;
?>
	</div>
<?php
			endif;
		endforeach;
	endif;
	if(isset($pageCount)&&intval($pageCount)>1&&!(isset($ajaxTemplate)&&$ajaxTemplate)):
		_part('pagination',0,[
			'pageSubURI' => "/{$sectionSlug}/"
		]);
	endif;
?>