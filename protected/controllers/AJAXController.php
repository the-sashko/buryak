<?php
	/*
		Controller for AJAX queries
	*/
	class AJAXController extends ControllerCore {

		public function default() : void {
			$this->redirect('/error/403/',301);
		}

		public function actionPostlist(int $page = 1) : void {
			$page = intval($page)>1?$page:1;
			$this->initModel('post');
			$posts = (new Post)->getPostList(0,$page);
			if(count($posts)>0){
				$this->render('main',[
					'posts' => $posts,
					'ajaxTemplate' => true,
					'isMainPage' => true
				]);
			}
			die('');
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

		public function actionTest($params = []) : void {
			var_dump($_REQUEST);
			$res = [
				'params' => $params,
				'get' => $this->get,
				'post' => $this->post,
				'request' => $_REQUEST
			];
			$this->returnJSON(true,$res);
		}
	}
?>