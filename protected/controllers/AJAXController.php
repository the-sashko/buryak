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

		public function actionPost(array $params = []) : void {
			if(count($params)==2){
				$postID = (int)$params[0];
				$sectionID = (int)$params[1];
				if($postID>0&&$sectionID>0){
					$this->initModel('post');
					$post = (new Post)->getByRelativeID($postID,$sectionID);
					if(count($post)>0){
						$this->render('snippet',[
							'post' => $post,
							'ajaxTemplate' => true,
							'isMainPage' => false
						]);
					}
				}
			}
			die('err');
			$this->redirect('/error/404/',301);
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