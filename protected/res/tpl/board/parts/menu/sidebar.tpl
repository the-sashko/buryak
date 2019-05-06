<?php if (!$isMainPage): ?>
<div class="large-3 medium-3 small-12 column hide-for-small-only sidebar">
	<aside>
		<nav>
			<div class="hide-for-medium-only">
				<?php
					if(isset($sections)&&is_array($sections)&&count($sections)>0):
						foreach ($sections as $section):
				?>
				<a href="/<?=$section['name'];?>/"><?php if(strlen($section['title'])>0): ?><span class="sidebar_title"><?=$section['title'];?></span><?php endif; ?><?php if(intval($section['age_restriction'])>0): ?>&nbsp;<span class="sidebar_age"><?=$section['age_restriction'];?>+</span><?php endif; ?></a>
				<?php
						endforeach;
				?>
				<a href="/all/"><span class="sidebar_title">All</span>&nbsp;<span class="sidebar_count">99+</span></a>
			</div>
			<div class="show-for-medium-only">
				<?php
						foreach ($sections as $section):
				?>
				<a href="/<?=$section['name'];?>/"><span class="sidebar_title">/<?=$section['name'];?>/</span><?php if(intval($section['age_restriction'])>0): ?>&nbsp;<span class="sidebar_age"><?=$section['age_restriction'];?>+</span><?php endif; ?></a>
				<?php
						endforeach;
				?>
				<a href="/all/"><span class="sidebar_title">/all/</span>&nbsp;<span class="sidebar_count">99+</span></a>
			</div>
				<?php
					endif;
				?>
		</nav>
	</aside>
</div>
<?php endif; ?>