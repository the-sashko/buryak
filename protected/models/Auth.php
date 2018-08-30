<?php

	/*
		class for user auth in admin panel 
	*/

	class Auth extends ModelCore {

		public function login(string $email = '', string $hash = '') : bool {
			die('Comming soon...');
		}

		public function logout() : bool {
			die('Comming soon...');
		}

		public function setPassword(string $pswd = '') : bool {
			die('Comming soon...');
		}

		public function create(string $email = '', string $hash = '') : bool {
			die('Comming soon...');
		}

		public function remove(int $id = 0) : bool {
			die('Comming soon...');
		}

		public function setSectionRights(int $id = 0, int $sectionID = 0) : bool {
			die('Comming soon...');
		}

		public function removeSectionRights(int $id = 0, int $sectionID = 0) : bool {
			die('Comming soon...');
		}

		public function isModerator() : bool {
			die('Comming soon...');
		}

		public function isAdmin() : bool {
			die('Comming soon...');
		}

		public function checkRights(int $sectionID = 0) : bool {
			die('Comming soon...');
		}


	}
?>