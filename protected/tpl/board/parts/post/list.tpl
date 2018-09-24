<?php
	if(isset($posts)&&is_array($posts)):
		foreach($posts as $post):
			_part('post/card',0,[
				'post' => $post,
				'type' => 'section'
			]);
			if(isset($post['posts'])&&is_array($post['posts'])&&count($post['posts'])>0&&!(isset($isMainPage)&&$isMainPage)):
?>
	<div class="related_posts">
<?php
				$countSubposts = 0;
				foreach($post['posts'] as $subpost):
					if($countSubposts >= count($post['posts'])-4):
						_part('post/card',0,[
							'post' => $subpost,
							'type' => 'section'
						]);
					endif;
					$countSubposts++;
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