<?php
class ApiController extends ControllerCore
{
    public $isOutputJSON = true;

    public function actionPost($apiMethod = 'get') : void
    {
        switch ($apiMethod) {
            case 'get':
                $this->_getPosts();
                break;
            case 'post':
                $this->_setPost();
                break;
            case 'put':
                $this->_editPost();
                break;
            case 'patch':
                $this->_editPost();
                break;
            case 'delete':
                $this->_removePost();
                break;
            default:
                throw new Exception('Not Implemented', 501);
                break;
        }
    }

    public function actionThread($apiMethod = 'get') : void
    {
        switch ($apiMethod) {
            case 'get':
                $this->_getThreads();
                break;
            default:
                throw new Exception('Not Implemented', 501);
                break;
        }
    }

    public function actionSection($apiMethod = 'get') : void
    {
        switch ($apiMethod) {
            case 'get':
                $this->_getSections();
                break;
            default:
                throw new Exception('Not Implemented', 501);
                break;
        }
    }

    public function actionPage($apiMethod = 'get') : void
    {
        switch ($apiMethod) {
            case 'get':
                $this->_getPage();
                break;
            default:
                throw new Exception('Not Implemented', 501);
                break;
        }
    }

    private function _getPosts()
    {
        $posts = $this->getModel('post')->getAllByPage($this->page);

        if (count($posts) < 1) {
            $this->returnJSON(FALSE, []);
        }

        $resData = [];

        foreach ($posts as $post){
            $resData = $post->getDataArray(['id', 'title', 'text']);
        }

        $this->returnJSON(FALSE, $resData);
    }

    private function _setPost()
    {
        if (!array_key_exists('data', $this->post)) {
            $this->returnJSON(FALSE, []);
        }

        $data = $this->post['data'];
        $data = json_decode($data, TRUE);

        $postModel = $this->getModel('post');

        list($status, $errors) = $postModel->create($data, FALSE);

        $errors = !$status ? $errors : [];

        $this->returnJSON($status, $errors);
    }

    private function _editPost()
    {
        $postID = (int) $this->URLParam;

        if (!array_key_exists('data', $this->post) || $postID < 1) {
            $this->returnJSON(FALSE, []);
        }

        $data = $this->post['data'];
        $data = json_decode($data, TRUE);

        $postModel = $this->getModel('post');

        list($status, $errors) = $postModel->edit($postID, $data);

        $errors = !$status ? $errors : [];

        $this->returnJSON($status, $errors);
    }

    private function _removePost()
    {
        $postID = (int) $this->URLParam;

        if (!$postID < 1) {
            $this->returnJSON(FALSE, []);
        }

        $postModel = $this->getModel('post');

        list($status, $errors) = $postModel->edit($postID, $data);

        $errors = !$status ? $errors : [];

        $this->returnJSON($status, $errors);
    }

    private function _getThreads()
    {
        $threads = $this->getModel('post')->getAllThreadsByPage($this->page);

        if (count($threads) < 1) {
            $this->returnJSON(FALSE, []);
        }

        $resData = [];

        foreach ($threads as $thread){
            $resData = $thread->getDataArray(['id', 'title', 'text']);
        }

        $this->returnJSON(FALSE, $resData);
    }

    private function _getSections()
    {
        $sections = $this->getModel('section')->getAllByPage($this->page);

        if (count($sections) < 1) {
            $this->returnJSON(FALSE, []);
        }

        $resData = [];

        foreach ($sections as $section){
            $resData = $section->getDataArray(['id', 'title', 'slug']);
        }

        $this->returnJSON(FALSE, $resData);
    }

    private function _getPage()
    {
        $staticPage = $this->getStaticPage($this->URLParam);

        $this->returnJSON(TRUE, $staticPage);
    }
}
?>
