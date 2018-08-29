<?php

	/* load all available libraries */

	foreach(scandir(getcwd().'/../protected/common/lib/') as $fileItem){ // if exist any directory (in library location) that contain init.php file - including this file
		if(
			$fileItem!='.' &&
			$fileItem!='..' &&
			is_dir(getcwd().'/../protected/common/lib/'.$fileItem) &&
			is_file(getcwd().'/../protected/common/lib/'.$fileItem.'/init.php')
		){
			require_once(getcwd().'/../protected/common/lib/'.$fileItem.'/init.php');
		}
	}
?>