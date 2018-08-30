<?php
	/*
		Controller for AJAX queries
	*/
	class AJAXController extends ControllerCore {

		public function default() : void {
			$this->redirect('/error/403/',301);
		}

		public function actionGetnewposts(int $maxPostID = -1) : void {
			die('Comming soon...');
		}

		public function actionWrite() : void {
			die('Comming soon...');
		}
	}
?>