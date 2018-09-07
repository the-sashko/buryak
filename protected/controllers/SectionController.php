<?php
	/*
		Controller display lists of posts (except main page), lists of threads and single threads
	*/
	class SectionController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionList(array $params = ['all',1]) : void {
			if(count($params)!=2){
				$this->redirect('/error/404/');
			}
			$sectionName = (string)$params[0];
			$sectionPage = (int)$params[1];
			if($sectionPage < 1){
				$this->redirect("/{$section['name']}/",301);
			}
			$this->initModel('section');
			$this->initModel('post');
			if($sectionName!='all'){
				$section = (new Section)->getByName($sectionName);
				if(count($section)<1){
					$this->redirect('/error/404/');
				}
				$posts = (new Post)->getThreadList($section['id'],$sectionPage);
				if($sectionPage > 1 && count($posts) < 1){
					$this->redirect("/{$section['name']}/");
				}
			} else {
				$posts = (new Post)->getThreadList(0,$sectionPage);
			}
			$this->commonData['URLPath'] = [
				0 => [
					'url' => "/{$section['name']}/",
					'title' => $sectionPage>1?"{$section['title']} (page {$sectionPage})":"{$section['title']}"
				] 
			];
			$this->commonData['pageTitle'] = $sectionPage>1?"{$section['title']} (page {$sectionPage})":"{$section['title']}";
			$this->render('section',[
				'section' => $section,
				'posts' => $posts
			]);
		}

		public function actionThead(int $int = 0) : void {
			die('Comming soon...');
		}
	}
?>