<?php
	/*
		Default controller for front-office
	*/
	class MainController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionAllposts(int $page = 1) : void {
			$this->render('main',[
			]);
		}

		public function actionPage(string $slug = '') : void {
			die('Comming soon...');
		}

		public function actionOptions() : void {
			die('Comming soon...');
		}

		public function actionError(int $code = 404) : void {
			if($code<400&&$code>526){
				$this->header('/error/404/',301);
			}
			http_response_code($code);
			$this->render('error',[
				'code' => $code
			]);
		}

		public function actionBan() : void {
			die('Comming soon...');
		}
	}
?>