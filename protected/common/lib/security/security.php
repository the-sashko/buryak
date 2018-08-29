<?php

	/*
		Trait for security functions
	*/

	trait Security {
		
		/*
			escaping all dangerous data
			input and output - mixed types string or array of strings
		*/

		public function escapeInput(mixed $input = NULL) : mixed {
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
		public function adminHashPass(string $pswd = '') : string{ // make hash form password for admin users or moderators
			$salt1 = $this->configData['security']['salt'][0];
			$salt2 = $this->configData['security']['salt'][1];
			return hash('sha512',hash('sha256', $pswd.$salt1).$pswd.hash('md5', $pswd.$salt2));
		}
		public function adminHashToken(int $id = -1, string $login = '') : string{ // make session token for admin users or moderators
			$salt1 = $this->configData['security']['salt'][2];
			$salt2 = $this->configData['security']['salt'][3];
			return hash('sha512',hash('sha256', $login.$salt1).$pswd.$id.hash('md5', $id.$salt2));
		}
	}
?>