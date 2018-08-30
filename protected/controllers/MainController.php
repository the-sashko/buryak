<?php
	/*
		Default controller for front-office
	*/
	class MainController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionAllposts(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionPage(string $slug = '') : void {
			die('Comming soon...');
		}

		public function actionOptions() : void {
			die('Comming soon...');
		}

		public function actionError(int $code = 404) : void {
			die('Comming soon...');
		}

		public function actionBan() : void {
			die('Comming soon...');
		}
	}
?>