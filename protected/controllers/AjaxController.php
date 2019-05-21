/storage/web/fajno.in/www/protected/core/storage/web/fajno.in/www/protected/core<?php
class AjaxController extends ControllerCore
{
    public $isOutputJSON = true;

    public function actionAllposts() : void
    {
        $posts = $this->getModel('post')->getList($this->page, FALSE);

        $this->returnJSON(TRUE, $posts);
    }

    public function actionAllthreads() : void
    {
        $posts = $this->getModel('post')->getList($this->page, FALSE);

        $this->returnJSON(TRUE, $posts);
    }

    public function actionPost() : void
    {
        $postID = (int) $this->URLParam;

        if ($postID < 1) {
            $this->returnJSON(FALSE, []);
        }
        
        $post = $this->getModel('post')->getByID($postID);

        if ($post === NULL) {
            $this->returnJSON(FALSE, []);
        }

        $this->returnJSON(TRUE, [
            'post' => $post
        ]);
    }

    public function actionThread() : void
    {
        $postID = (int) $this->URLParam;

        if ($postID < 1) {
            $this->returnJSON(FALSE, []);
        }
        
        $post = $this->getModel('post')->getThreadByID($postID);

        if ($post === NULL) {
            $this->returnJSON(FALSE, []);
        }

        $this->returnJSON(TRUE, [
            'post' => $post
        ]);
    }

    public function actionWrite() : void
    {
        list($status, $errors) = $this->getModel('post')->create($this->post);

        if ($status) {
            $errors = [];
        }

        $this->returnJSON($status, $errors);
    }

    public function actionSearch() : void
    {
        if (!array_key_exists('keyword', $this->post)) {
            $this->returnJSON(FALSE, []);
        }

        $keyword = $this->post['keyword'];
        $keyword = preg_replace('/\s+/su', ' ', $keyword);
        $keyword = preg_replace('/(^\s)|(\s$)$/su', '', $keyword);

        if ($keyword < 3) {
            $this->returnJSON(FALSE, []);
        }

        $posts = $this->getModel('post')->search($keyword, $this->page);

        if (!count($posts) < 1) {
            $this->returnJSON(FALSE, []);
        }

        $this->returnJSON(TRUE, $posts);
    }
}
?>
