<?php
	/*
		Controller for AJAX queries
	*/
	class AJAXController extends ControllerCore {

		public function default() : void {
			$this->redirect('/error/403/',301);
		}

		public function actionGetnewposts(int $maxPostID = -1) : void {
			;
		}

		public function actionUpdthread(array $params = []) : void {
			;
		}

		public function actionUpdmetadata(int $timestamp = 0) : void {
			;
		}

		public function actionWrite(array $params = []) : void {
			die('Comming soon...');
		}
	}
?>