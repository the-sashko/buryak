<?php
	/*
		Default controller for back-office
	*/
	class AdminController extends ControllerCore {
		public function __construct(array $postData = [], array $getData = []){
			parent::__construct($postData,$getData);
			die('Forbidden! Comming soon...');
		}

		public function default() : void {
			die('Comming soon...');
		}

		public function actionLogin(string $scope = 'mod') : void {
			die('Comming soon...');
		}

		public function actionLogout(string $scope = 'mod') : void {
			die('Comming soon...');
		}

		public function actionPosts(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionEditpost(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSpam() : void {
			die('Comming soon...');
		}

		public function actionBan(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionEditban(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionInbox(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionMessages(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSections() : void {
			die('Comming soon...');
		}

		public function actionEditsection(string $name = '') : void {
			die('Comming soon...');
		}

		public function actionSettings() : void {
			die('Comming soon...');
		}

		public function actionCache() : void {
			die('Comming soon...');
		}

		public function actionUsers() : void {
			die('Comming soon...');
		}

		public function actionEdituser(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionRestore(string $scope = 'mod') : void {
			die('Comming soon...');
		}

		public function actionSetpassword(string $scope = 'mod') : void {
			die('Comming soon...');
		}
	}
?>