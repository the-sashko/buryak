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

			Proority of definition variable data (from low to hight):

			1. Data from config files

			2. Data from common controller array

			2. Data sending to render function

			The highter priority data replae lower priority data (when names of variables are equal)
		*/

		public function render(string $template = 'main', array $dataParams = [], int $ttl = 0) : void {
			$GLOBALS['templateParams'] = isset($GLOBALS['templateParams'])?$GLOBALS['templateParams']:[];

			/*
				make all data from maim config global
			*/

			foreach ($this->configData['main'] as $idx => $configItem) {
				$GLOBALS['templateParams'][$idx] = $configItem;
			}

			/*
				make all common data global
			*/

			foreach ($this->commonData as $idx => $commonItem) {
				$GLOBALS['templateParams'][$idx] = $commonItem;
			}

			/*
				make $dataParams global
				make $this->templateScope global
				$this->templateScope - define template directory
			*/	
			foreach ($dataParams as $idx => $dataParamItem) {
				$GLOBALS['templateParams'][$idx] = $dataParamItem;
			}
			$GLOBALS['templateScope'] = $this->templateScope;

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