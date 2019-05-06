<?php
class AdminController extends ControllerCore
{
    public $templaterScope = 'admin';

    public function actionLogin() : void
    {
        $err      = [];
        $formData = [];
        $auth     = new Auth();

        if ($auth->isAdmin() || $auth->isMod()) {
            $this->redirect("/{$scope}/posts/");
        }

        if(
            isset($this->post['email']) &&
            isset($this->post['pswd']) &&
            preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$this->post['email']) &&
            strlen($this->post['pswd']) > 0
        ){
            $formData = $this->post;
            $pswdHash = $this->adminHashPass($this->post['pswd']);

            if ($auth->login($this->post['email'], $pswdHash)) {
                $tokenHash = $this->adminHashToken($this->post['email']);

                if($auth->setToken($this->post['email'], $tokenHash)){
                    $this->redirect("/{$scope}/posts/");
                } else {
                    $err[] = 'Internal server error!';
                }
            } else {
                $err[] = 'Invalid login or password!';
            }
        }

        $this->render('login', [
            'purePage' => TRUE,
            'formData' => $formData,
            'err'      => $err,
            'scope'    => $scope
        ]);
    }

    public function actionLogout() : void
    {
        (new Auth)->logout();

        $this->redirect("/{$scope}/login/");
    }

    public function actionPosts() : void
    {
        $this->initModel('post');

        $posts = (new Post)->getPostList(0, $this->page, TRUE);

        if (count($posts) < 1 && $this->page != 1) {
            $this->page --;
            $this->redirect('/page-'.$this->page.'/');
        }

        $postPageCount = (new Post)->getThreadPageCount(0, TRUE);

        $this->render('post/list', [
            'posts'     => $posts,
            'pageCount' => $postPageCount,
            'currPage'  => $this->page
        ]);
    }

    public function actionEditpost() : void
    {
        //To-Do
    }

    public function actionDelpost() : void
    {
        //To-Do
    }

    public function actionSpam() : void
    {
        $this->render('admin/spam');
    }

    public function actionBan() : void
    {
        //To-Do
    }

    public function actionEditban() : void
    {
        //To-Do
    }

    public function actionDelban() : void
    {
        //To-Do
    }

    public function actionCron() : void
    {
        $this->initModel('cron');
        $this->initModel('dictionary');

        $cron = new Cron();

        if(
            isset($this->post['action']) &&
            strlen($this->post['action']) > 0 &&
            isset($this->post['value']) &&
            intval($this->post['value']) > 0 &&
            isset($this->post['type']) &&
            intval($this->post['type']) > 0
        ){
            $action = $this->post['action'];
            $value  = (int) $this->post['value'];
            $type   = (int) $this->post['type'];

            if ($cron->addJob($action, $value, $type)) {
                $this->redirect('/admin/cron/');
            }
        }

        $this->render('admin/cron/list', [
            'cronJobs'    => $cron->getJobs(),
            'cronActions' => $cron->getActions(),
            'cronTypes'   => (new Dictionary)->getCronTypes(),
            'formData'    => $this->post
        ]);
    }

    public function actionEditcron() : void
    {
        //To-Do
    }

    public function actionDelcron() : void
    {
        //To-Do
    }

    public function actionInbox() : void
    {
        //To-Do
    }

    public function actionMessages() : void
    {
        //To-Do
    }

    public function actionSections() : void
    {
        $this->initModel('Section');
        $this->initModel('Dictionary');

        $succ     = FALSE;
        $err      = [];
        $formData = $this->post;
        $section  = new Section();

        if(
            !isset($this->post['title']) ||
            !strlen($this->post['title']) > 0 ||
            !isset($this->post['name']) ||
            !strlen($this->post['name']) > 0 ||
            !isset($this->post['desription']) ||
            !strlen($this->post['desription']) > 0
        ){
            $this->render('admin/section/list', [
                'sections'       => $section->list(),
                'statuses'       => (new Dictionary)->getSectionStatuses(),
                'err'            => [],
                'succ'           => FALSE,
                'successMessage' => '',
                'formData'       => $formData
            ]);
        }

        $title           = $this->post['title'];
        $name            = $this->post['name'];
        $desription      = $this->post['desription'];
        $defaultUserName = '';
        $ageRestriction  = 0;
        $statusID        = 1;
        $sort            = 0;

        if (
            isset($this->post['default_user_name']) &&
            strlen($this->post['default_user_name']) > 0
        ) {
            $defaultUserName = $this->post['default_user_name'];
        }

        if (
            isset($this->post['age_restriction']) &&
            intval($this->post['age_restriction']) > 0
        ) {
            $ageRestriction = (int) $this->post['age_restriction'];
        }

        if (
            isset($this->post['status_id']) &&
            intval($this->post['status_id']) > 0
        ) {
            $statusID = (int) $this->post['status_id'];
        }

        if (isset($this->post['sort']) && intval($this->post['sort']) > 0) {
            $sort = (int) $this->post['sort'];
        }

        list($status, $err) = $section->create(
            $name,
            $title,
            $desription,
            $defaultUserName,
            $ageRestriction,
            $statusID,
            $sort
        );

        if ($status) {
            $succ     = TRUE;
            $formData = [];
        }

        $this->render('admin/section/list', [
            'sections'       => $section->list(),
            'statuses'       => (new Dictionary)->getSectionStatuses(),
            'err'            => $err,
            'succ'           => $succ,
            'successMessage' => 'Section created!',
            'formData'       => $formData
        ]);
    }

    public function actionEditsection() : void
    {
        //To-Do
    }

    public function actionDelsection() : void
    {
        //To-Do
    }

    public function actionSettings() : void
    {
        $this->render('admin/settings');
    }

    public function actionCache() : void {
        foreach (glob(getcwd().'/../protected/res/cache/db/*') as $cacheDir) {
            if (!is_dir($cacheDir)) {
                continue;
            }

            foreach (glob("{$cacheDir}/*") as $cacheFile) {
                unlink($cacheFile);
            }
        }

        $this->render('admin/cache');
    }

    public function actionUsers() : void
    {
        $this->initModel('Dictionary');

        $auth = new Auth();

        $this->render('admin/user/list', [
            'users' => $auth->list(),
            'roles' => (new Dictionary)->getAdminRoles()
        ]);
    }

    public function actionEdituser() : void
    {
        //To-Do
    }

    public function actionDeluser() : void
    {
        $id = (int) $URLParam;

        if ((new Auth)->remove($id)) {
            $this->redirect('/admin/user/');
        }

        throw new Exception('Can Not Remove Admin User');
    }

    public function actionRestore() : void
    {
        //To-Do
    }

    public function actionSetpassword() : void
    {
        //To-Do
    }
}
?>
