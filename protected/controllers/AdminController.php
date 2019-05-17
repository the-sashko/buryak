<?php
class AdminController extends ControllerCore
{
    public $templaterScope = 'admin';

    public function __construct()
    {
        parent::__construct();

        $auth = $this->initModel('auth');
        $serverInfo =  $this->initPlugin('serverInfo');

        if (
            !$auth->isSignedIn() &&
            $serverInfo->get('REQUEST_URI') != '/admin/login/'
        ) {
            $this->redirect('/admin/login/');
        }
    }

    public function actionLogin() : void
    {
        if ($this->initModel('auth')->isSignedIn()) {
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
        $this->initModel('auth')->signout();

        $this->redirect("/admin/login/");
    }

    public function actionPost() : void
    {
        $posts = $this->initModel('post')->getList($this->page, TRUE);

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
        //To-Do
    }

    public function actionDelpost() : void
    {
        //To-Do
    }

    public function actionSpam() : void
    {
        //To-Do
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
        //To-Do
    }

    public function actionEditcron() : void
    {
        //To-Do
    }

    public function actionDelcron() : void
    {
        //To-Do
    }

    public function actionSection() : void
    {
        $formData = $this->post;
        $sectionModel = $this->initModel('section');
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
        //To-Do
    }

    public function actionDeluser() : void
    {
        //To-Do
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
