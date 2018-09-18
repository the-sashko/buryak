<?php
	/*
		Default controller for front-office
	*/
	class MainController extends ControllerCore {
		
		use Markup;
		use Youtube;
		use Link;

		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionAllposts(int $page = 1) : void {
			if($page<1){
				$this->redirect('/',301);
			}
			$this->initModel('post');
			$allPosts = (new Post)->getPostList(0,$page);
			if(count($allPosts)<1&&$page!=1){
				$page--;
				$this->redirect("/page-{$page}/");
			}
			$this->render('main',[
				'posts' => $allPosts,
				'isMainPage' => true
			]);
		}

		public function actionPage(string $slug = '') : void {
			if(strlen($slug)>0&&is_file(getcwd()."/../protected/res/static_pages/{$slug}.txt")){
				$pageData = file_get_contents(getcwd()."/../protected/res/static_pages/{$slug}.txt");
				$pageData = explode("\n===\n",$pageData);
				if(count($pageData)>1){
					$pageTitle = $pageData[0];
					$pageText = $pageData[1];
					$pageText = $this->normalizeSyntax($pageText);
					$pageText = $this->parseLink($pageText);
					$pageText = $this->parseLinkShortCode($pageText);
					$pageText = $this->parseYoutubeID($pageText);
					$pageText = $this->parseYoutubeShortCode($pageText);
					$pageText = $this->normalizeText($pageText);
					$pageText = $this->markup2HTML($pageText);
					$this->commonData['pageTitle'] = $pageTitle;
					$this->render('page',[
						'staticPageText' => $pageText
					]);
				}
			}
			$this->redirect('/error/404/');
		}

		public function actionOptions() : void {
			die('Comming soon...');
		}

		public function actionError(int $code = 404) : void {
			if($code<400&&$code>526){
				$this->header('/error/404/',301);
			}
			$this->commonData['pageTitle'] = "Error {$code}";
			$this->commonData['URLPath'] = [
				0 => [
					'url' => "/error/{$code}/",
					'title' => "Error {$code}"
				] 
			];
			http_response_code($code);
			$this->render('error',[
				'code' => $code
			]);
		}

		public function actionBan() : void {
			die('Comming soon...');
		}
		
		public function actionCaptcha(string $id = '') : void {
			die('Comming soon...');
		}		
	}
?>