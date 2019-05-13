<?php
class MainController extends ControllerCore
{
    public function actionAllposts() : void
    {
        $posts = $this->initModel('post')->getAllPosts($this->page);

        if (count($posts) < 1 && $this->page !== 1) {
            $this->page --;
            $this->redirect('/page-'.$this->page.'/');
        }

        $this->render('main', [
            'posts' => $posts
        ]);
    }

    public function actionPage() : void
    {
        //To-Do
    }

    public function actionError() : void
    {
        $code = (int) $this->URLParam;

        if ($code < 400 && $code > 526) {
            $this->redirect('/error/404/', TRUE);
        }

        http_response_code($code);

        $this->render('error', [
            'code' => $code
        ]);
    }       
}
?>
