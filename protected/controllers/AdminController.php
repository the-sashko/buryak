<?php
class AdminController extends ControllerCore
{
    public $templaterScope = 'admin';

    public function __construct()
    {
        parent::__construct();

        $authModel        = $this->getModel('auth');
        $serverInfoPlugin = $this->getPlugin('serverInfo');

        if (
            !$authModel->isSignedIn() &&
            $serverInfoPlugin->get('REQUEST_URI') != '/admin/login/'
        ) {
            $this->redirect('/admin/login/');
        }
    }

    public function actionLogin() : void
    {
        if ($this->getModel('auth')->isSignedIn()) {
            $this->redirect('/admin/post/');
        }
        
        $formData = $this->post;

        if (!count($formData) > 0) {
            $this->render('login', [
                'formData' => [],
                'err'      => []
            ]);
        }

        if ($this->_checkUserCredentials()) {
            if (!$this->_signIn()) {
                throw new Exception('Internal Error');
            }

            $this->redirect('/admin/post/');
        }

        $this->render('login', [
            'formData' => $formData,
            'err'      => 'Invalid Login Or Password'
        ]);
    }

    public function actionLogout() : void
    {
        $this->getModel('auth')->signout();

        $this->redirect("/admin/login/");
    }

    public function actionPost() : void
    {
        $posts = $this->getModel('post')->getList($this->page, TRUE);

        if (count($posts) < 1 && $this->page != 1) {
            $this->page --;
            $this->redirect('/admmin/page-'.$this->page.'/');
        }

        $this->render('post/list', [
            'posts' => $posts
        ]);
    }

    public function actionEditpost() : void
    {
        $postID = (int) $this->URLParam;
        $formData = [];
        $errors   = [];

        if (count($this->post) > 0) {
            $formData = $this->post;

            $postModel             = $this->getModel('post');
            list($status, $errors) = $postModel->edit($postID, $formData);

            if ($status) {
                $this->redirect('/admin/post/');
            }
        }

        $this->render('post/form', [
            'formData' => $formData,
            'errors'   => $errors
        ]);
    }

    public function actionDelpost() : void
    {
        $postID = (int) $this->URLParam;

        $this->getModel('post')->remove($postID);
        $this->redirect('/admin/post/');
    }

    public function actionSpam() : void
    {
        //To-Do
    }

    public function actionBan() : void
    {
        $banList = $this->getModel('user')->getBanList($this->page);

        if (count($banList) < 1 && $this->page != 1) {
            $this->page --;
            $this->redirect('/ban/page-'.$this->page.'/');
        }

        $this->render('user/ban/list', [
            'banList' => $banList
        ]);
    }

    public function actionEditban() : void
    {
        $banID = (int) $this->URLParam;
        $formData = [];
        $errors   = [];

        if (count($this->post) > 0) {
            $formData = $this->post;

            $userModel             = $this->getModel('user');
            list($status, $errors) = $userModel->editBan($banID, $formData);

            if ($status) {
                $this->redirect('/admin/post/');
            }
        }

        $this->render('user/ban/form', [
            'formData' => $formData,
            'errors'   => $errors
        ]);
    }

    public function actionDelban() : void
    {
        $userID = (int) $this->URLParam;

        $this->getModel('user')->removeBan($userID);

        $this->redirect('/admin/ban/');
    }

    public function actionCron() : void
    {
        $cronList = $this->getModel('cron')->getList($this->page);

        if (count($cronList) < 1 && $this->page != 1) {
            $this->page --;
            $this->redirect('/cron/page-'.$this->page.'/');
        }

        $this->render('cron/list', [
            'cronList' => $cronList
        ]);
    }

    public function actionEditcron() : void
    {
        $cronID = (int) $this->URLParam;
        $formData = [];
        $errors   = [];

        if (count($this->post) > 0) {
            $formData = $this->post;

            $cronModel             = $this->getModel('cron');
            list($status, $errors) = $cronModel->edit($cronID, $formData);

            if ($status) {
                $this->redirect('/admin/cron/');
            }
        }

        $this->render('cron/form', [
            'formData' => $formData,
            'errors'   => $errors
        ]);
    }

    public function actionDelcron() : void
    {
        $cronID = (int) $this->URLParam;

        $this->getModel('cron')->remove($cronID);

        $this->redirect('/admin/cron/');
    }

    public function actionSection() : void
    {
        $formData = $this->post;
        $sectionModel = $this->getModel('section');
        $sectionList = $sectionModel->getList($this->page, TRUE);

        if (!count($formData) > 0) {
            $this->render('section/list', [
                'sections' => $sectionList,
                'err'      => [],
                'succ'     => FALSE,
                'formData' => []
            ]);
        }

        list($status, $err) = $sectionModel->create($formData);

        $this->render('section/list', [
            'sections' => $sectionList,
            'err'      => $err,
            'succ'     => $status,
            'formData' => $formData
        ]);
    }

    public function actionEditsection() : void
    {
        $sectionID = (int) $this->URLParam;
        $formData  = [];
        $errors    = [];

        if (count($this->post) > 0) {
            $formData = $this->post;

            $sectionModel          = $this->getModel('section');
            list($status, $errors) = $sectionModel->edit($sectionID, $formData);

            if ($status) {
                $this->redirect('/admin/section/');
            }
        }

        $this->render('section/form', [
            'formData' => $formData,
            'errors'   => $errors
        ]);
    }

    public function actionDelsection() : void
    {
        $sectionID = (int) $this->URLParam;

        $this->getModel('section')->remove($sectionID);

        $this->redirect('/admin/section/');
    }

    public function actionSettings() : void
    {
        $this->render('admin/settings');
    }

    public function actionCache() : void
    {
        //To-Do
    }

    public function actionUser() : void
    {
        //To-Do
    }

    public function actionEdituser() : void
    {
        $userID   = (int) $this->URLParam;
        $formData = [];
        $errors   = [];

        if (count($this->post) > 0) {
            $formData = $this->post;

            $userModel             = $this->getModel('user');
            list($status, $errors) = $userModel->edit($userID, $formData);

            if ($status) {
                $this->redirect('/admin/user/');
            }
        }

        $this->render('user/form', [
            'formData' => $formData,
            'errors'   => $errors
        ]);
    }

    public function actionDeluser() : void
    {
        $cronID = (int) $this->URLParam;

        $this->getModel('cron')->removeBan($cronID);

        $this->redirect('/admin/cron/');
    }

    public function actionPassword() : void
    {
        //To-Do
    }

    private function _checkUserCredentials() : bool
    {
        //To-Do
        return FALSE;
    }

    private function _signIn() : bool
    {
        //To-Do
        return FALSE;
    }
}
?>
