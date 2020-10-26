<?php
/**
 * Class For Imageboard Posts
 */
class Post extends ModelCore
{
    public function write(?array $postData = null): PostForm
    {
        $postForm = null;

        $this->object->start();

        try {
            $postForm = new PostForm($postData);

            $postForm->checkInputParams();

            if (!$postForm->getStatus()) {
                $this->object->rollback();

                return $postForm;
            }

            $postVO = $this->_mapPostForm($postForm);

            if (empty($postVO) || !$postForm->getStatus()) {
                $postForm->setFail();
                $this->object->rollback();

                return $postForm;
            }

            $row = $postVO->exportRow();

            if (!$this->object->insertPost($row)) {
                $postForm->setFail();
                $postForm->setError('Can Not Save Post');

                $this->object->rollback();

                return $postForm;
            }

            $idPost = $this->object->getMaxId();

            if (empty($idPost)) {
                $postForm->setFail();
                $postForm->setError('Can Not Save Post');

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
                $postForm->setFail();
                $postForm->setError('Media File Is Not Set');

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
                $postForm->setFail();
                $postForm->setError('Can Not Save Media File');

                $this->object->rollback();

                return $postForm;
            }

            $this->object->commit();
        } catch (
            Core\Plugins\Database\Exceptions\DatabasePluginException $exp
        ) {
            $errorMessage = $exp->getMessage();

            if (APP_MODE != 'dev') {
                $errorMessage = 'Database Error';
            }

            $postForm->setFail();
            $postForm->setError($errorMessage);
        } catch (\Exception $exp) {
            $postForm->setFail();
            $postForm->setError($exp->getMessage());
        }

        return $postForm;
    }

    private function _mapPostForm(PostForm &$postForm): ?PostValuesObject
    {
        $cryptPlugin = $this->getPlugin('crypt');
        $cryptConfig = $this->getConfig('crypt');

        if (
            !array_key_exists('salt', $cryptConfig) ||
            empty($cryptConfig['salt'])
        ) {
            $postForm->setFail();
            $postForm->setError('Crypt Config File Has Bad Format');

            return null;
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
            $postForm->setFail();
            $postForm->setError('This Section Is Not Exists');

            return null;
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

        $user = $this->getModel('user');
        $user->init();

        $sessonId = $user->getSessionId();

        $postVO->setText($text);
        $postVO->setTitle($title);
        $postVO->setUsername($username);
        $postVO->setSectionId($idSection);
        $postVO->setRelativeCode($relativeCode);
        $postVO->setPassword($password);
        $postVO->setTripCode($tripCode);
        $postVO->setSessionId($sessonId);

        return $postVO;
    }
}
