<?php

	/*
		trait for rendering HTML pages
	*/

	trait Templater {

		/*
			function for render HTML page
			$template - name of tpl page file
			$dataParams - array of data that can be used into template
			$ttl - time to live template cache in seconds (0 - for disale)
		*/

		public function render(string $template = 'main', array $dataParams = [], int $ttl = 0) : void {
			
			/*
				make $dataParams global
				make $this->templateScope global
				$this->templateScope - define template directory
			*/

			$GLOBALS['templateParams'] = $dataParams;
			$GLOBALS['templateScope'] = $this->templateScope;

			/*
				make all data from maim config global
			*/

			foreach ($this->configData['main'] as $idx => $configItem) {
				$GLOBALS['templateParams'][$idx] = $configItem;
			}

			$GLOBALS['templateTTL'] = $ttl; // make $ttl global
			$template = strlen($template)>0?$template:'main'; // if template page not set - define as default value

			/*
				if caching enable - make directory for chached template parts
			*/ 

			if($ttl>0){

				/*
					make directory name form URL
				*/
				$currSlug = $_SERVER['REQUEST_URI'];
				$currSlug = str_replace('/','_', $currSlug);
				$currSlug = preg_replace('/(^_)|(_$)/su','',$currSlug);
				$tplCacheDir = getcwd().'/../protected/res/cache/tpl/'.$currSlug;

				/*
					creating (if it's not exist) directory for current URL. Set correct rights on it
				*/

				if(!is_dir($tplCacheDir)){
					mkdir($tplCacheDir);
					chmod($tplCacheDir,0775);
				}

				/*
					creating (if it's not exist) sub-directory for current URL and scope. Set correct rights on it
				*/

				$tplCacheDir = $tplCacheDir.'/'.$this->templateScope;
				if(!is_dir($tplCacheDir)){
					mkdir($tplCacheDir);
					chmod($tplCacheDir,0775);
				}

				/*
					creating (if it's not exist) sub-directory for URL, scope and template page. Set correct rights on it
				*/

				$tplCacheDir = "{$tplCacheDir}/{$template}";
				if(!is_dir($tplCacheDir)){
					mkdir($tplCacheDir);
					chmod($tplCacheDir,0775);
				}

				$GLOBALS['templateCacheDir'] = $tplCacheDir; //make path for cache global variable
			}

			/*
				creating variables from gloabal array
			*/

			foreach($GLOBALS['templateParams'] as $param => $value) {
				$$param = $value;
			}

			include_once(getcwd().'/../protected/tpl/'.$this->templateScope.'/index.tpl'); //include inital tamplate file

			/*
				if disabled caching whole HTML of page stoped executing stript after render
			*/

			if(!$this->pageCache){
				die();
			}
		}
	}
?>