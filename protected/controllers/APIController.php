<?php
	/*
		Controller for API
	*/
	class APIController extends ControllerCore {
		public function __construct(array $postData = [], array $getData = []){
			parent::__construct($postData,$getData);
			die('Forbidden! Comming soon...');
		}
		public function actionPosts(array $data = []) : void {
			// ...
			$this->checkToken($data['token']);
			die('Comming soon...');
		}
		public function actionPost(array $data = []) : void {
			// ...
			$this->checkToken($data['token']);
			die('Comming soon...');
		}
		public function actionThreads(array $data = []) : void {
			// ...
			$this->checkToken($data['token']);
			die('Comming soon...');
		}
		public function actionThread(array $data = []) : void {
			// ...
			$this->checkToken($data['token']);
			die('Comming soon...');
		}
		public function actionSections(string $token = '') : void {
			$this->checkToken($token);
			die('Comming soon...');
		}
		public function actionWrite(string $token = '') : void {
			$this->checkToken($token);
			die('Comming soon...');
		}
		public function actionPages(string $token = '') : void {
			$this->checkToken($token);
			die('Comming soon...');
		}
		public function checkToken(string $token = '') : void {
			die('Comming soon...');
		}
	}
?>