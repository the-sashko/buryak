<?php

	/*
		Functions for render HTML and that cat be called without classes/trates
		So, template contait 2 types of tpl-files
		1 - pages for single use in one page
		2 - parts for multiple use in one page
	*/

	/*
		Function for render template page 
		$templatePage - name of template page file
	*/

	function renderPage(string $templatePage = '') : void {

		/*
			creating variables from gloabal array
		*/

		foreach ($GLOBALS['templateParams'] as $param => $value) {
			$$param = $value;
		}

		/*
			including tpl file
		*/
		include_once(getcwd().'/../protected/tpl/'.$GLOBALS['templateScope'].'/pages/'.$templatePage.'.tpl');
	}

	/*
		Function for render template part 
		$templatePart - name of template part file
		$ttl - time to live template cache in seconds (0 - for disale)
		$templateData - array of data specific for this calling of this part
	*/

	function renderPart(string $templatePart = '', int $ttl = 0, array $templateData = []) : bool {

		/*
			If cache enabled - init caching
		*/

		if($ttl>0){
			if(is_file($GLOBALS['templateCacheDir'].'/'.$templatePart.'.dat')){
				$partCacheData = file_get_contents($GLOBALS['templateCacheDir'].'/'.$templatePart.'.dat');
				$partCacheData = json_decode($partCacheData,true);
				if(
					isset($partCacheData['timestamp']) &&
					intval($partCacheData['timestamp']) > time() &&
					isset($partCacheData['data'])
				){
					echo $partCacheData['data'];
					return true;
				}
			} else {
				ob_start();
			}
		}

		/*
			make $emplateData visible globaly
		*/

		foreach ($templateData as $templateDataItemIdx => $templateDataItem) {
			$GLOBALS['templateParams'][$templateDataItemIdx] = $templateDataItem;
		}

		/*
			creating variables from gloabal array
		*/

		foreach ($GLOBALS['templateParams'] as $param => $value) {
			$$param = $value;
		}
		include(getcwd().'/../protected/tpl/'.$GLOBALS['templateScope'].'/parts/'.$templatePart.'.tpl');

		/*
			If cache enabled - saving cache of part
		*/

		if($ttl > 0){
			$partContent = ob_get_clean();
			echo $partContent;
			$partCacheData = [
				'timestamp' => time() + $ttl,
				'data' => $partContent
			];
			if(is_file($GLOBALS['templateCacheDir'].'/'.$templatePart.'.dat')){
				unlink($GLOBALS['templateCacheDir'].'/'.$templatePart.'.dat');
			}
			file_put_contents($GLOBALS['templateCacheDir'].'/'.$templatePart.'.dat',json_encode($partCacheData));
		}
		return true;
	}

	/*
		syntactic sugar for renderPage function
	*/

	function _page(string $templatePage = '') : void {
		renderPage($templatePage);
	}

	/*
		syntactic sugar for renderPart function
	*/

	function _part(string $templatePart = '', bool $cache = false, array $templateData = []) : void {
		$ttl = $cache ? (int)$GLOBALS['templateTTL'] : 0; // if $ttl not set for this part - set form common value
		renderPart($templatePart, $ttl, $templateData);
	}
?>