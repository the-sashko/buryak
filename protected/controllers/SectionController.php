<?php
	/*
		Controller display lists of posts (except main page), lists of threads and single threads
	*/
	class SectionController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionList(array $params = ['all',1]) : void {
			die('Comming soon...');
		}

		public function actionThead(int $int = 0) : void {
			die('Comming soon...');
		}
	}
?>