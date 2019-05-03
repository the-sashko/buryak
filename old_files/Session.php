<?php

	/*
		class for user sessions
	*/

	class Session extends ModelCore {

		use GeoIP;

		public function setID(string $id = '') : void {
			$_SESSION['user_id'] = $id;
		}

		public function getID() : string {
			return isset($_SESSION['user_id'])?strval($_SESSION['user_id']):'';
		}

		public function getData() : array {
			if(isset($_SESSION['user_data'])&&is_array($_SESSION['user_data'])){
				return $_SESSION['user_data'];
			}
			return [];
		}

		public function setData(array $data = []) : void {
			$_SESSION['user_data'] = isset($_SESSION['user_data'])&&is_array($_SESSION['user_data'])?$_SESSION['user_data']:[];
			foreach ($data as $idx => $val){
				$_SESSION['user_data'][$idx] = $val;
			}
		}

		public function removeData(string $idx = '') : void {
			if(isset($_SESSION['user_data'])&&is_array($_SESSION['user_data'])&&isset($_SESSION['user_data'][$idx])){
				unset($_SESSION['user_data'][$idx]);
			}
		}
	}
?>