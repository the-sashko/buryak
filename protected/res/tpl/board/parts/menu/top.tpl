<nav class="large-9 medium-9 small-6 columns hide-for-small-only top_menu">
	<a href="/page/example/">Example</a>
	<a href="/search/">Search</a>
</nav>
<div class="small-6 columns top_menu show-for-small-only top_menu_btn"><a href="#">Меню</a></div>
<nav class="large-12 medium-12 small-12 columns top_menu_pda">
	<h3>Sections</h3>
	<?php
		if(isset($sections)&&is_array($sections)&&count($sections)>0):
			foreach ($sections as $section):
		?>
	<a href="/<?=$section['name'];?>/"><?=$section['title'];?><?php if(intval($section['age_restriction'])>0): ?>&nbsp;<span class="pda_menu_age"><?=$section['age_restriction'];?>+</span><?php endif; ?></a>
	<?php
			endforeach;
		endif;
	?>
	<h3>Pages</h3>
	<a href="/page/example/">Example</a>
	<a href="/search/">Search</a>
	<h3>Other</h3>
	<a href="/all/">All threads</a>
</nav>