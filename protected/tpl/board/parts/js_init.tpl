<script type="text/javascript">
	var ajaxLoad = <?=isset($ajaxLoad)&&$ajaxLoad?'true':'false';?>;
	var ajaxSearch = <?=isset($ajaxSearch)&&$ajaxSearch?'true':'false';?>;
<?php
	if(isset($ajaxLoad)&&$ajaxLoad):
?>
	var ajaxPage = <?=isset($currPage)&&intval($currPage)>1?intval($currPage):1;?>;
	var ajaxAction = '<?=isset($ajaxAction)&&strlen($ajaxAction)>0?$ajaxAction:'posts';?>';
	var ajaxLock = false;
	var ajaxTimeOut = 0;
<?php
	endif;
?>
<?php
	if(isset($ajaxSearch)&&$ajaxSearch):
?>
	var searchPage = 1;
	var searchKeyword = '';
<?php
	endif;
?>
	var postSnippetLevel = 1;
	var postSnippetAJAXLock = false;
	var threadUPDAJAXLock = false;
	var postSnippetX = -1;
	var postSnippetY = -1;
	var currThreadID = <?=isset($threadID)?$threadID:'-1';?>;
	var currThreadMaxReplyID = <?=isset($threadMaxReplyID)?$threadMaxReplyID:'-1';?>;
</script>