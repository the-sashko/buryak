<?php
	/*
		Controller for post action (except read): write, remove, etc
	*/
	class PostController extends ControllerCore {
		
		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionWrite() : void {
			$this->initModel('section');
			$this->initModel('post');
			$status = false;
			$err = [];
			if(
				isset($this->post['section_id']) &&
				intval($this->post['section_id']) > 0
			){
				$sectionID = isset($this->post['section_id'])?(int)$this->post['section_id']:0;
				$threadID = isset($this->post['thread_id'])?(int)$this->post['thread_id']:0;
				$text = isset($this->post['text'])?$this->post['text']:'';
				$title = isset($this->post['title'])?$this->post['title']:'';
				$name = isset($this->post['name'])?$this->post['name']:'';
				$pswd = isset($this->post['pswd'])?trim($this->post['pswd']):'';
				$captcha = isset($this->post['captcha'])?$this->post['captcha']:'';
				$redirectType = isset($this->post['after'])?$this->post['after']:'go2thread';
				$makeTripCode = isset($this->post['trip_code'])&&$this->post['trip_code']=='on';
				$withoutMedia = isset($this->post['no_media'])&&$this->post['no_media']=='on';
				$sectionID = $sectionID>0?$sectionID:0;
				$threadID = $threadID>0?$threadID:0;
				$redirectType = $redirectType == 'go2thread';
				$section = (new Section)->getByID($sectionID);
				$makeTripCode = $makeTripCode&&strlen($pswd)>0;
				if(!count($section)>0){
					$this->redirect('/error/404/');
				}
				if(
					$section['status_id'] == 1 ||
					$section['status_id'] == 2
				) {
					if(strlen(trim($text)) > 0 ){
						if(strlen($text) <=  15000){
							if($threadID>0){
								$threadPost = (new Post)->getByID($threadID);
								if(count($threadPost)>0){
									$threadReplies = (new Post)->getReplies($threadID);
									if(count($threadReplies)>=$this->configData['main']['thread_limit']){
										$err[] = 'Thread have maximum count od replies!';
									}
								} else {
									$err[] = 'Thread is not exist!';
								}
							}
							$name = strlen(trim($name))>0?$name:$section['default_user_name'];
							$name = strlen(trim($name))>0?$name:$this->configData['main']['default_user_name'];
						} else {
							$err[] = 'Text is so long (more then 15000 characters)!';
						}
					} else {
						$err[] = 'Text is empty!';
					}
				} else {
					$err[] = 'You can not post to this section!';
				}
				if(count($err)<1){
					$tripCode = $makeTripCode?$this->makeTripCode($pswd):'';
					$pswd = strlen($pswd)>0?$this->userHashPass($pswd):'';
					$userIP = $this->getIP();
					list($status,$data) = (new Post)->create($text,$title,$name,$pswd,$tripCode,$userIP,$threadID,$sectionID);
					if($status){
						if($redirectType&&is_array($data['id'])&&intval($data['id'])>0){
							if($threadID>0){
								$this->redirect("/{$section['name']}/{$threadID}/#last");
							} else {
								$this->redirect("/{$section['name']}/{$data['id']}/");
							}
						} else {
							$this->redirect("/{$section['name']}/");
						}
					} else {
						$err = count($data)>0?$data:$err;
					}
				}
			} else {
				$this->redirect('/',301);
			}
			$err = count($err)>0?$err:'Internal error!';
			$_SESSION['flash_data'] = isset($_SESSION['flash_data'])&&is_array($_SESSION['flash_data'])?$_SESSION['flash_data']:[];
			$_SESSION['flash_data']['postFormError'] = $err;
			if($threadID > 0){
				$this->redirect("/{$section['name']}/{$threadID}/");
			} else {
				$this->redirect("/{$section['name']}/");
			}
		}

		public function actionRemove(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSearch(){
			$this->commonData['URLPath'] = [
				0 => [
					'url' => '#',
					'title' => "Search"
				]
			];
			$this->commonData['pageTitle'] = 'Search';
			$this->render('search',[
				'ajaxSearch' => true
			]);
		}
	}
?>