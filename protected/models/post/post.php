<?php
/**
 * Class For Imageboard Posts
 */
class Post extends ModelCore
{
    public function write(?array $postData = null): PostForm
    {
        $this->object->start();

        //try {
            $postForm = new PostForm($postData);

            $postForm->checkInputParams();

            if (!$postForm->getStatus()) {
                $this->object->rollback();

                return $postForm;
            }

            $postVO = $this->_mapPostForm($postForm);

            if (!$postForm->getStatus()) {
                $this->object->rollback();

                return $postForm;
            }

            $uploadPlugin = $this->getPlugin('upload');
            $uploadPlugin->upload(['jpeg','jpg','gif','png'], 1024*1024*16, 'media');

            if (!empty($uploadPlugin->getError())) {
                throw new Exception('message');
            }

            $file = $uploadPlugin->getFiles();
            $file = $file['media'][0];

            $imagePlugin = $this->getPlugin('image');

            $row = $postVO->exportRow();

            if (!$this->object->insertPost($row)) {
                //$this->object->rollback();
                //throw new Exception('');

                $this->object->rollback();

                return $postForm;
            }

            $idPost = $this->object->getMaxId();

            if (empty($idPost)) {
                //$this->object->rollback();
                //throw new Exception('');

                $this->object->rollback();

                return $postForm;
            }

            $mediaDir = sprintf('%s/%d', date('Y/m/d/H/i/s'), $idPost);

            $mediaDirPath = sprintf(
                '%s/%s',
                PostValuesObject::MEDIA_DIR_PATH,
                $mediaDir
            );

            $imagePlugin->resize(
                $file,
                $mediaDirPath,
                'image',
                'png',
                PostValuesObject::IMAGE_SIZES
            );

            $mediaFileName = explode('/', $file);
            $mediaFileName = end($mediaFileName);

            if (preg_match('/^(.*?)\.gif$/su', $mediaFileName)) {
                copy($file, $mediaDirPath.'/'.$mediaFileName);
                chmod($mediaDirPath.'/'.$mediaFileName, 0775);
            }

            $postVO->setMediaName($mediaFileName);
            $postVO->setMediaDir($mediaDir);

            $row = $postVO->exportRow();

            if (!$this->object->updatePostById($row, $idPost)) {
                //$this->object->rollback();
                //throw new Exception('');

                $this->object->rollback();

                return $postForm;
            }
        //} catch (\Exception $exp) {
        //    $this->object->rollback();
        //    throw $exp;
        //}

        $this->object->commit();

        return $postForm;
    }

    private function _mapPostForm(PostForm &$postForm): PostValuesObject
    {
        $postVO = $this->getVO();

        $text        = $postForm->getText();
        $title       = $postForm->getTitle();
        $username    = $postForm->getUsername();
        $sectionSlug = $postForm->getSectionSlug();

        $sectionVO = $this->getModel('section')->getVOBySlug($sectionSlug);

        if (empty($sectionVO)) {
            throw new Exception('');
        }

        $idSection       = $sectionVO->getId();
        $defaultUsername = $sectionVO->getDefaultUsername();

        $relativeCode = $this->object->getMaxRelativeCode($idSection);
        $relativeCode++;

        if (empty($username)) {
            $username = $defaultUsername;
        }

        if (empty($username)) {
            $username = PostValuesObject::DEFAULT_USERNAME;
        }

        $postVO->setText($text);
        $postVO->setTitle($title);
        $postVO->setUsername($username);
        $postVO->setSectionId($idSection);
        $postVO->setRelativeCode($relativeCode);
        $postVO->setSessionId(1);

        return $postVO;
    }
}
