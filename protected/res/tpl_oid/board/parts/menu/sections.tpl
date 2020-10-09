<?php if(isset($isMainPage)&&$isMainPage&&isset($sections)&&is_array($sections)&&count($sections)>0): ?>
<div class="section_list" class="hide-for-small-only">
	<div class="row fullWidth">
		<h2 class="large-12 medium-12 small-12 columns">Boards</h2>
	</div>
	<nav class="row fullWidth">
		<ul class="large-6 medium-6 small-6 columns">
			<?php
				$sectionListCounter = 0;
				foreach ($sections as $section):
					$sectionListCounter++;
					if($sectionListCounter<count($sections)/2):
			?>
			<li>
				<a href="/<?=$section['name'];?>/">/<?=$section['name'];?>/<?=strlen($section['title'])>0?'&nbsp;<span>'.$section['title'].'</span>':'';?><?=intval($section['age_restriction'])>16?'&nbsp;<span class="section_list_age">'.$section['age_restriction'].'+</span>':'';?><?=strlen($section['description'])>0?'&nbsp;‐&nbsp;'.$section['description']:'';?></a>
			</li>
			<?php
					endif;
				endforeach;
			?>			
			<li>
				<a href="/all/">/all/&nbsp;<span>All</span>&nbsp;‐&nbsp;All threads</a>
			</li>
		</ul>
		<ul class="large-6 medium-6 small-6 columns">
			<?php
				$sectionListCounter = 0;
				foreach ($sections as $section):
					$sectionListCounter++;
					if($sectionListCounter>=count($sections)/2):
			?>
			<li>
				<a href="/<?=$section['name'];?>/">/<?=$section['name'];?>/<?=strlen($section['title'])>0?'&nbsp;<span>'.$section['title'].'</span>':'';?><?=intval($section['age_restriction'])>16?'&nbsp;<span class="section_list_age">'.$section['age_restriction'].'+</span>':'';?><?=strlen($section['description'])>0?'&nbsp;‐&nbsp;'.$section['description']:'';?></a>
			</li>
			<?php
					endif;
				endforeach;
			?>
		</ul>
	</nav>
	<div class="mouse_icon">
		<div class="mouse_icon_wheel">&nbsp;</div>
	</div>
</div>
<?php endif; ?>