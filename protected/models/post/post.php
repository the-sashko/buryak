<?php
/**
 * Class For Imageboard Posts
 */
class Post extends ModelCore
{
    public function write(?array $postData = null): PostForm
    {
        $this->object->test();

        $postForm = new PostForm($postData);

        $postForm->checkInputParams();

        if (!$postForm->getStatus()) {
            return $postForm;
        }

        //$postVO = $this->_mapPostForm($postForm);

        return $postForm;
    }

    /*private function _mapPostForm(PostForm &$postForm): PostValuesObject
    {
        $postVO = $this->getVO();

        $text = $postForm->getText();

        $postVO->setText() = $text;

        return $postVO;
    }*/
}
