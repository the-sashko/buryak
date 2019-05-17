<?php
class PostController extends ControllerCore
{
    public function actionWrite() : void
    {
        $user = $this->initModel('user')->getCurrent();

        if (!$user->isBan()) {
            $this->redirect('/user/ban/');
        }

        if (!$user->isHuman()) {
            $this->redirect('/user/check/');
        }

        list($status, $errors) = $this->initModel('post')->create($this->post);

        if ($status) {
            $user->setFlashSuccess();
            $this->redirect($user->_getRedirectURL());
        }

        if (is_scalar($errors)) {
            $errors = [strval($errors)];
        }

        $user->setFlashErrors($errors);
        $this->redirect($user->_getRedirectURL());
    }

    public function actionRemove() : void
    {
        $user = $this->initModel('user')->getCurrent();

        list($status, $errors) = $this->initModel('post')->remove($this->post);

        if ($status) {
            $user->setFlashSuccess();
            $this->redirect($user->_getRedirectURL());
        }

        $user->setFlashErrors($errors);
        $this->redirect($user->_getRedirectURL());
    }

    public function actionSearch()
    {
        $this->render('posts/search');
    }

    public function actionThread() : void
    {
        list($sectionSlug, $postRelativeCode) = $this->_parseThreadURLParams();

        $sectionID = $this->initModel('section')->getBySlug($sectionSlug);

        if (!$sectionID > 0) {
            $this->redirect('/error/404/');
        }

        $postModel = $this->initModel('post');

        $post = $postModel->getPostBySection($sectionID, $postRelativeCode);

        if ($post->getParentID() > 0) {
            $redirectURL = '/'.$sectionSlug.'/'.
                           $post->getParent()->getRelativeCode().
                           '/#'.$postRelativeCode;

            $this->redirect($redirectURL,TRUE);
        }

        $thread = $postModel->getThreadByPostID($post->getID());

        $this->render('post/thread', [
            'thread' => $thread
        ]);
    }

    public function actionAll() : void
    {
        $posts = $this->initModel('post')->getAllPosts($this->page);

        if (count($posts) < 1 && $this->page !== 1) {
            $this->page --;
            $this->redirect('/page-'.$this->page.'/');
        }

        $this->render('post/all', [
            'posts' => $posts
        ]);
    }
}
?>
