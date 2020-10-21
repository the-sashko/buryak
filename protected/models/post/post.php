<?php
/**
 * Class For Imageboard Posts
 */
class Post extends ModelCore
{
    public function write(?array $postData = null): PostForm
    {
        $this->object->start();

        try {
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

            if ($postForm->isWithoutMedia()) {
                $this->object->commit();

                return $postForm;
            }

            $mediaDir = sprintf('%s/%d', date('Y/m/d/H/i/s'), $idPost);

            $media = $this->getModel('media');

            $mediaVO = $media->upload($mediaDir);

            if (empty($mediaVO) && false) {
                //$this->object->rollback();
                //throw new Exception('');
                $this->object->rollback();

                return $postForm;
            }

            if (empty($mediaVO)) {
                $this->object->commit();

                return $postForm;
            }

            $mediaFileName = $mediaVO->getFileName();
            $mediaType     = $mediaVO->getType();

            $postVO->setMediaName($mediaFileName);
            $postVO->setMediaDir($mediaDir);
            $postVO->setMediaType($mediaType);

            $row = $postVO->exportRow();

            if (!$this->object->updatePostById($row, $idPost)) {
                //$this->object->rollback();
                //throw new Exception('');
                $this->object->rollback();

                return $postForm;
            }

            $this->object->commit();
        } catch (\Exception $exp) {
            $this->object->rollback();
            throw $exp;
        }

        return $postForm;
    }

    private function _mapPostForm(PostForm &$postForm): PostValuesObject
    {
        $cryptPlugin = $this->getPlugin('crypt');
        $cryptConfig = $this->getConfig('crypt');

        if (
            !array_key_exists('salt', $cryptConfig) ||
            empty($cryptConfig['salt'])
        ) {
            throw new Exception('message1');
        }

        $cryptSalt = (string) $cryptConfig['salt'];

        $postVO = $this->getVO();

        $tripCode = null;

        $text        = $postForm->getText();
        $title       = $postForm->getTitle();
        $username    = $postForm->getUsername();
        $password    = $postForm->getPassword();
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

        if (!empty($password) && $postForm->isGenerateTripCode()) {
            $tripCode = $cryptPlugin->getTripCode($password);
        }

        if (!empty($password)) {
            $password = $cryptPlugin->getHash($password, $cryptSalt);
        }

        $postVO->setText($text);
        $postVO->setTitle($title);
        $postVO->setUsername($username);
        $postVO->setSectionId($idSection);
        $postVO->setRelativeCode($relativeCode);
        $postVO->setPassword($password);
        $postVO->setTripCode($tripCode);
        $postVO->setSessionId(1);

        return $postVO;
    }
}
