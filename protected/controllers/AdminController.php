<?php
	/*
		Default controller for back-office
	*/
	class AdminController extends ControllerCore {

		public $scope = 'guest';
		public $templateScope = 'admin';

		public function __construct(array $postData = [], array $getData = []){
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

		public function actionDelpost(int $id = 0) : void {
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

		public function actionDelban(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionInbox(int $page = 1) : void {
			die('Comming soon...');
		}

		public function actionMessages(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSections() : void {
			$succ = false;
			$err = [];
			$formData = $this->post;
			$this->initModel('Section');
			$this->initModel('Dictionary');
			$section = new Section();
			if(
				isset($this->post['title']) &&
				strlen($this->post['title'])>0 &&
				isset($this->post['name']) &&
				strlen($this->post['name'])>0 &&
				isset($this->post['desription']) &&
				strlen($this->post['desription'])>0
			){
				$title = $this->post['title'];
				$name = $this->post['name'];
				$desription = $this->post['desription'];
				$defaultUserName = isset($this->post['default_user_name'])&&strlen($this->post['default_user_name'])>0?$this->post['default_user_name']:'';
				$ageRestriction = isset($this->post['age_restriction'])&&intval($this->post['age_restriction'])>0?(int)$this->post['age_restriction']:0;
				$statusID = isset($this->post['status_id'])&&intval($this->post['status_id'])>0?(int)$this->post['status_id']:1;
				$sort = isset($this->post['sort'])&&intval($this->post['sort'])>0?(int)$this->post['sort']:0;
				list($status,$err) = $section->create($name,$title,$desription,$defaultUserName,$ageRestriction,$statusID,$sort);
				if($status){
					$succ = true;
					$formData = [];
				}
			}
			$this->render('admin/section/list',[
				'sections' => $section->list(),
				'statuses' => (new Dictionary)->getSectionStatuses(),
				'err' => $err,
				'succ' => $succ,
				'successMessage' => 'Section created!',
				'formData' => $formData
			]);
		}

		public function actionEditsection(string $name = '') : void {
			die('Comming soon...');
		}

		public function actionDelsection(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionSettings() : void {
			die('Comming soon...');
		}

		public function actionCache() : void {
			die('Comming soon...');
		}

		public function actionUsers() : void {
			$this->initModel('Dictionary');
			$auth = new Auth();
			$this->render('admin/user/list',[
				'users' => $auth->list(),
				'roles' => (new Dictionary)->getAdminRoles()
			]);
		}

		public function actionEdituser(int $id = 0) : void {
			die('Comming soon...');
		}

		public function actionDeluser(int $id = 0) : void {
			if((new Auth)->remove($id)){
				$this->redirect('/admin/user');
			}
			die('Internal error!');
		}

		public function actionRestore(string $scope = 'mod') : void {
			die('Comming soon...');
		}

		public function actionSetpassword(string $scope = 'mod') : void {
			die('Comming soon...');
		}
	}
?>