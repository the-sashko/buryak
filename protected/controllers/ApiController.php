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
        //To-Do
    }

    private function _setPost()
    {
        //To-Do
    }

    private function _editPost()
    {
        //To-Do
    }

    private function _removePost()
    {
        //To-Do
    }

    private function _getThreads()
    {
        //To-Do
    }

    private function _getSections()
    {
        //To-Do
    }

    private function _getPage()
    {
        //To-Do
    }
}
?>
