<?php
	/*
		Controller for post action (except read): write, remove, etc
	*/
	class PostController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionWrite() : void {
			die('Comming soon...');
		}

		public function actionRemove(int $id = 0) : void {
			die('Comming soon...');
		}
	}
?>