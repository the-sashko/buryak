<?php
	
	/*
		Functions for caching whole HTML output of page 
	*/

	/*
		Init caching on start web appliction
	*/
	function cache_init() : void{
		if(!count($_POST)>0){ // post data empty, so enabling cache

			/*
				Don't sure what is realy it do, will reFUCKtor it later
			*/

			$userSessionToken = isset($_SESSION)&&count($_SESSION)>0&&isset($_SESSION['cache_token'])?$_COOKIE['cache_token']:'';
			$cacheID = hash('md5',$_SERVER['REQUEST_URI']).$userSessionToken.hash('sha256',$_SERVER['REQUEST_URI']).hash('md5',$_SERVER['REQUEST_URI'].$userSessionToken);
			if(is_file(getcwd()."/../protected/cache/page/{$cacheID}.dat")){
				echo file_get_contents(getcwd()."/../protected/cache/page/{$cacheID}.dat");
				die();
			} else {
				$GLOBALS['cache_id'] = $cacheID;
				ob_start();
			}
		}
	}


	/*
		Save cached data when web appliction is end working
	*/

	function cache_save() : void{
		if(!count($_POST)>0){// post data empty, so cache enabled

			/*
				Don't sure what is realy it do, will reFUCKtor it later
			*/
			
			$cacheID = $GLOBALS['cache_id'];
			$time = date('d.m.Y H:i:s');
			$cacheContent = ob_get_clean();
			$cacheContent = html_minify($cacheContent);
			echo $cacheContent;
			file_put_contents(getcwd()."/../protected/cache/page/{$cacheID}.dat",$cacheContent);//"{$cacheContent}\n\n<!--\n\nCACHED AT {$time}\n\n!-->\n\n");
			chmod(getcwd()."/../protected/cache/page/{$cacheID}.dat",0775);
		}
	}

	/*
		Minify cached HTML for speed reasons
	*/

	function html_minify(string $html = '') : string {
		$html = preg_replace('/([\s]+)/su',' ',$html); // replace all spaсe(s), new line(s) and tab(s) by one spaсe
		$html = preg_replace('/\<(.*?)\>([\s]+)\<(.*?)\>/su','<$1><$3>',$html); //removing space(s) between tags
		$html = preg_replace('/\<\!\-\-(.*?)\-\-\>/su','',$html); //removing comments in HTML
		$html = preg_replace('/([\s]+)/su',' ',$html); // replace by double spaсes by one spaсe
		$html = preg_replace('/(^\s)(\s$)/su','',$html); // replace space(s) on start and end of HTML document
		$html = preg_replace('/\<(.*?)\>([\s]+)\<(.*?)\>/su','<$1><$3>',$html); //removing space(s) between tags again
		return $html;
	}
?>