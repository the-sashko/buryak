/storage/web/fajno.in/www/protected/core/storage/web/fajno.in/www/protected/core<?php
class AjaxController extends ControllerCore
{
    public function actionPostlist() : void
    {
        $this->initModel('post');

        $posts = (new Post)->getPostList(0, $this->page);

        if (count($posts) > 0) {
            $this->render('ajax/main', [
                'posts'        => $posts,
                'ajaxTemplate' => TRUE,
                'isMainPage'   => TRUE
            ]);
        }
    }

    public function actionThread() : void
    {
        if (count($params) !== 2) {
            $this->redirect('/error/404/', TRUE);
        }

        $threadID  = (int) $params[0];
        $postMaxID = (int) $postMaxID[1];

        if ($postMaxID > 0 && $postMaxID > 0) {
            $this->initModel('post');
            $posts = (new Post)->getNewPostsByThreadID(
                $threadID,
                $postMaxID
            );

            if (count($post) > 0) {
                $this->render('ajax/snippet', [
                    'post'         => $post,
                    'ajaxTemplate' => TRUE,
                    'isMainPage'   => FALSE
                ]);
            }
        }
    }

    public function actionUpdmetadata() : void
    {
        // To-Do
    }

    public function actionPost() : void
    {
        if (count($params) !== 2) {
            $this->redirect('/error/404/', TRUE);
        }

        $postID = (int) $params[0];
        $sectionID = (int) $params[1];

        if ($postID > 0 && $sectionID > 0) {
            $this->initModel('post');
            $post = (new Post)->getByRelativeID($postID, $sectionID);

            if (count($post) > 0) {
                $this->render('ajax/snippet', [
                    'post'         => $post,
                    'ajaxTemplate' => TRUE,
                    'isMainPage'   => FALSE
                ]);
            }
        }
    }

    public function actionWrite() : void
    {
        //To-Do
    }

    public function actionSearch()
    {
        if(
            isset($this->post['keyword']) &&
            strlen($this->post['keyword']) > 3
        ){
            $this->initModel('post');

            $posts = (new Post)->search($this->post['keyword']);

            if (count($posts) > 0) {
                $this->render('ajax/search', [
                    'posts'        => $posts,
                    'ajaxTemplate' => TRUE,
                    'isMainPage'   => TRUE
                ]);
            }
        }
    }
}
?>
