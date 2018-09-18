<?php
	trait translator {
		public function translate(string $word = '', string $langCode = '') : string {
			$langCode = trim($langCode);
			$langCode = (string)mb_convert_case($langCode,MB_CASE_LOWER);
			$langCode = strlen($langCode)!=2&&isset($_SESSION['user_data'])&&is_array($_SESSION['user_data'])&&isset($_SESSION['user_data']['lang'])?$_SESSION['user_data']['lang']:$langCode;
			$langCode = strlen($langCode)!=2?'en':$langCode;
			if(is_file(getcwd()."/../protected/common/lib/translator/dict/{$langCode}.json")&&strlen($word)>0){
				$dataJSON = file_get_contents(getcwd()."/../protected/common/lib/translator/dict/{$langCode}.json");
				$dictData = json_decode($dataJSON,true);
				$word = isset($dictData[$word])&&strlen($dictData[$word])>0?$dictData[$word]:$word;
			}
			return $word;
		}
	}