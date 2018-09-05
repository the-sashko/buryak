<?php

	/*
		Trait for security functions
	*/

	trait Security {
		
		/*
			escaping all dangerous data
			input and output - string or array of strings
		*/

		public function escapeInput($input = NULL) {
			if(!is_array($input)){ // if not array
				$input = (string)$input; // convert ot string type
				$input = strip_tags($input); // remove all tags
				$input = htmlspecialchars($input); // convert all special characters into html code analogs
				$input = addslashes($input); // escaping all special characters by add slashes
				$input = preg_replace('/(^\s+)|(\s+$)/su','',$input); // replacing spaces, new lines or tabulation from start and end of line
			} else { // if array maping by this function
				$input = array_map([$this,'escapeInput'],$input);
			}
			return $input;
		}
		public function adminHashPass(string $pswd = '') : string { // make hash form password for admin users or moderators
			$salt1 = $this->configData['security']['salt'][0];
			$salt2 = $this->configData['security']['salt'][1];
			return hash('sha512',hash('sha256', $pswd.$salt1).$pswd.hash('md5', $pswd.$salt2));
		}
		public function adminHashToken(string $email = '') : string{ // make session token for admin users or moderators
			$timestamp = (string)time();
			$salt1 = $this->configData['security']['salt'][2];
			$salt2 = $this->configData['security']['salt'][3];
			return hash('sha512',hash('sha256', $email.$salt1).$email.$timestamp.hash('md5', $timestamp.$salt2));
		}
		public function adminEmailToken(string $email = '') : string{ // make session token for admin users or moderators
			$timestamp = (string)time();
			$salt1 = $this->configData['security']['salt'][3];
			$salt2 = $this->configData['security']['salt'][4];
			return substr(hash('sha256', $salt1.$email.$timestamp.$salt2),3,16);
		}
	}
?>