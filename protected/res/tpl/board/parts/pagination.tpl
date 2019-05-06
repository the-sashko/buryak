<nav class="pagination"><?php
	if($pageCount>15):
		if($currPage>5&&($pageCount-$currPage)>4):
?><a href="<?=$pageSubURI;?>">1</a><a href="<?=$pageSubURI;?>page-2/">2</a><a href="<?=$pageSubURI;?>page-3/">3</a><span>...</span><a href="<?=$pageSubURI;?>page-<?=($currPage-1)?>/"><?=($currPage-1)?></a><span><?=$currPage?></span><a href="<?=$pageSubURI;?>page-<?=($currPage+1)?>/"><?=($currPage+1)?></a><span>...</span><a href="<?=$pageSubURI;?>page-<?=($pageCount-2)?>/"><?=($pageCount-2)?></a><a href="<?=$pageSubURI;?>page-<?=($pageCount-1)?>/"><?=($pageCount-1)?></a><a href="<?=$pageSubURI;?>page-<?=$pageCount?>/"><?=$pageCount?></a><?php
		elseif($currPage<=5):
			for($page = 1; $page <= $currPage; $page++):
				if($page != $currPage):
?><a href="<?=$pageSubURI;?><?=$page!=1?"page-{$page}/":''?>"><?=$page?></a><?php 
				else:
?><span><?=$currPage?></span><?php
				endif;
			endfor;
?><a href="<?=$pageSubURI;?>page-<?=($currPage+1)?>/"><?=($currPage+1)?></a><span>...</span><a href="<?=$pageSubURI;?>page-<?=($pageCount-2)?>/"><?=($pageCount-2)?></a><a href="<?=$pageSubURI;?>page-<?=($pageCount-1)?>/"><?=($pageCount-1)?></a><a href="<?=$pageSubURI;?>page-<?=$pageCount?>/"><?=$pageCount?></a><?php
		else:
?><a href="<?=$pageSubURI;?>">1</a><a href="<?=$pageSubURI;?>page-2/">2</a><a href="<?=$pageSubURI;?>page-3/">3</a><span>...</span><a href="<?=$pageSubURI;?>page-<?=($currPage-1)?>/"><?=($currPage-1)?></a><span><?=$currPage?></span><?php
			for($page = $currPage+1; $page <= $pageCount; $page++):
?><a href="<?=$pageSubURI;?>page-<?=$page?>/"><?=$page?></a><?php
			endfor;
?>
<?php
		endif;
	else:
		for($page = 1; $page <= $pageCount; $page++):
			if($page != $currPage):
?>
<a href="<?=$pageSubURI;?><?=$page!=1?"page-{$page}/":''?>"><?=$page?></a><?php
			else:
?><span><?=$page?></span><?php
			endif;
		endfor;
	endif;
?></nav>