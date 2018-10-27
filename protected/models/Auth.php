<?php

	/*
		class for user auth in admin panel 
	*/

	class Auth extends ModelCore {

		use Security;

		public $id = 0;
		public $role = '';
		public $openSections = [];

		public function __construct(){
			if(
				isset($_SESSION['auth_token']) &&
				isset($_SESSION['auth_email']) &&
				strlen($_SESSION['auth_token'])>0 &&
				strlen($_SESSION['auth_email'])>0
			){
				$token = $this->escapeInput($_SESSION['auth_token']);
				$email = $this->escapeInput($_SESSION['auth_email']);
				$sql = "
					SELECT
						`id` AS 'id',
						`role_id` AS 'role'
					FROM `admin_users`
					WHERE
						`email` = '{$email}' AND
						`token` = '{$token}' AND
						`is_active` = 1;
				";
				$res = $this->select($sql,'auth');
				if(count($res)>0&&is_array($res[0])&&isset($res[0]['id'])&&intval($res[0]['id'])>0){
					$this->id = (int)$res[0]['id'];
					if(intval($res[0]['role']==1)){
						$this->role = 'admin';
					} elseif(intval($res[0]['role']==2)){
						$this->role = 'mod';
					}
				}
			}
		}

		public function login(string $email = '', string $pswdHash = '') : bool {
			$sql = "
				SELECT
					`id` AS 'id'
				FROM `admin_users`
				WHERE
					`email` = '{$email}' AND
					`pswd` = '{$pswdHash}' AND
					`is_active` = 1;
			";
			$res = $this->select($sql,'auth');
			if(count($res)>0&&is_array($res[0])&&isset($res[0]['id'])&&intval($res[0]['id'])>0){
				return true;
			}
			return false;
		}

		public function logout() : void {
			$_SESSION['auth_email'] = '';
			$_SESSION['auth_token'] = '';
		}

		public function setToken(string $email = '', string $tokenHash = '') : bool {
			$_SESSION['auth_email'] = $email;
			$_SESSION['auth_token'] = $tokenHash;
			$sql = "
				UPDATE `admin_users`
				SET
					`token` = '{$tokenHash}'
				WHERE `email` = '{$email}';";
			return $this->query($sql,'auth');
		}

		public function setPassword(string $email = '', string $passwordHash = '') : bool {
			$sql = "
				UPDATE `admin_users`
				SET
					`pswd` = '{$passwordHash}'
				WHERE `email` = '{$email}';";
			return $this->query($sql,'auth');
		}

		public function create(string $name = '', string $email = '') : bool {
			die('Comming soon...');
		}

		public function remove(int $id = 0) : bool {
			$sql = "
				DELETE FROM `admin_users`
				WHERE `id` = {$id};";
			return $this->request($sql,'auth');
		}

		public function setSectionRights(int $id = 0, int $sectionID = 0) : bool {
			die('Comming soon...');
		}

		public function removeSectionRights(int $id = 0, int $sectionID = 0) : bool {
			die('Comming soon...');
		}

		public function isAdmin() : bool {
			return $this->role == 'admin';
		}

		public function isMod() : bool {
			return $this->role == 'mod';
		}

		public function checkRights(int $sectionID = 0) : bool {
			return in_array($sectionID,$this->openSections);
		}
		public function list() : array {
			$sql = "
				SELECT
					u.`id` AS 'id',
					u.`name` AS 'name',
					u.`email` AS 'email',
					r.`title` AS 'role',
					u.`is_active` AS 'status'
				FROM `admin_users` AS u
				LEFT JOIN `dictionary_admin_roles` AS r ON r.`id` = u.`role_id`;
			";
			return $this->select($sql,'auth');
		}
	}
?>