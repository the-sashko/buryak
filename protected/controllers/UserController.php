<?php
class UserController extends ControllerCore
{
    public $user = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->getModel('user')->getCurrent();
    }

    public function actionOptions() : void
    {
        if (array_key_exists('options', $this->post)) {
            $this->user->setOptions($this->post['options']);

            $this->redirect('/options/');
        }

        $userOptions = $this->user->getOptions();

        $this->render('user/options', [
            'userOptions' => $userOptions
        ]);
    }

    public function actionEmbedded() : void
    {
        $this->user->checkUserClient();

        $this->render('user/iframe',[
            'currentUser' => $this->user
        ]);
    }

    public function actionCheck() : void
    {
        $redirectTo = $this->user->getRedirectURL();

        $this->user->checkHuman();

        if ($this->user->isHuman()) {
            $this->redirect($redirectTo);
        }

        if ($this->user->isBanned()) {
            $this->redirect('/user/ban/');
        }

        $this->render('user/captcha');
    }

    public function actionBan() : void
    {
        if (!$this->user->isBanned()) {
            $this->redirect('/');
        }

        $this->render('user/ban');
    }
}
?>
