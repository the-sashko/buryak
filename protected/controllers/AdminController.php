<?php
	/*
		Default controller for back-office
	*/
	class AdminController extends ControllerCore {

		public $scope = 'guest';
		public $templateScope = 'admin';

		public function __construct(array $postData = [], array $getData = []){
			//var_dump($_SERVER); die();
			parent::__construct($postData,$getData);
			$this->initModel('auth');
			$auth = new Auth();
			if(
				!$auth->isAdmin() &&
				!$auth->isMod() &&
				!preg_match('/^\/admin\/login\/(.*?)$/su',$_SERVER['REQUEST_URI'])
			){
				$this->redirect('/admin/login/');
			}
		}

		public function default() : void {
			$this->redirect('/admin/posts/',301);
		}

		public function actionLogin(string $scope = 'mod') : void {
			$err = [];
			$formData = [];
			$auth = new Auth();
			if($auth->isAdmin()||$auth->isMod()){
				$this->redirect("/{$scope}/posts/");
			}
			if(
				isset($this->post['email']) &&
				isset($this->post['pswd']) &&
				preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$this->post['email']) &&
				strlen($this->post['pswd'])>0
			){
				$formData = $this->post;
				$pswdHash = $this->adminHashPass($this->post['pswd']);
				if($auth->login($this->post['email'],$pswdHash)){
					$tokenHash = $this->adminHashToken($this->post['email']);
					if($auth->setToken($this->post['email'],$tokenHash)){
						$this->redirect("/{$scope}/posts/");
					} else {
						$err[] = 'Internal server error!';
					}
				} else {
					$err[] = 'Invalid login or password!';
				}
			}
			$this->render('login',[
				'purePage' => true,
				'formData' => $formData,
				'err' => $err,
				'scope' => $scope
			]);
		}

		public function actionLogout(string $scope = 'mod') : void {
			(new Auth)->logout();
			$this->redirect("/{$scope}/login/");
		}

		public function actionPosts(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionEditpost(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSpam() : void {
			die('Comming soon...');
		}

		public function actionBan(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionEditban(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionInbox(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionMessages(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSections() : void {
			die('Comming soon...');
		}

		public function actionEditsection(string $name = '') : void {
			die('Comming soon...');
		}

		public function actionSettings() : void {
			die('Comming soon...');
		}

		public function actionCache() : void {
			die('Comming soon...');
		}

		public function actionUsers() : void {
			die('Comming soon...');
		}

		public function actionEdituser(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionRestore(string $scope = 'mod') : void {
			die('Comming soon...');
		}

		public function actionSetpassword(string $scope = 'mod') : void {
			die('Comming soon...');
		}
	}
?>