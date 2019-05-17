<?php
class Post extends ModelCore
{
    public function getAll(
        int  $page       = 1,
        bool $onlyThreads = FALSE,
        bool $viewHidden = FALSE
    ) : array
    {
        $posts = $this->object->getAllPosts($page, $onlyThreads, $viewHidden);

        if (count($posts) < 1) {
            return NULL;
        }

        return $this->getVOArray($posts);
    }

    public function getCountAll(
        bool $onlyThreads = FALSE,
        bool $viewHidden = FALSE
    ) : int
    {
        return $this->object->getCountAllPosts($onlyThreads, $viewHidden);
    }

    public function getAllThreads(
        int  $page       = 0,
        bool $viewHidden = FALSE
    ) : array
    {
        return $this->getAll($page, TRUE, $viewHidden);
    }

    public function getCountAllThreads(bool $viewHidden = FALSE) : int
    {
        return $this->getCountAll(TRUE, $viewHidden);
    }

    public function getByID(
        int  $postID     = 0,
        bool $onlyThreads = FALSE,
        bool $viewHidden = FALSE
    ) : PostVO
    {
        $postData = $this->object->getPostByID($postID, $onlyThreads, $viewHidden);

        if (count($postData) < 1) {
            return NULL;
        }

        return $this->getVO($postData);
    }

    public function getThreadByID(
        int  $postID     = 0,
        bool $viewHidden = FALSE
    ) : PostVO
    {
        return $this->getByID($postID, TRUE, $viewHidden);
    }

    public function getByRelativeCode(
        int  $relativeCode = 0,
        bool $onlyThreads   = FALSE,
        int  $sectionID    = 0,
        bool $viewHidden   = FALSE
    ) : PostVO
    {
        $postData = $this->object->getPostByRelativeCode(
            $relativeCode,
            $onlyThreads,
            $sectionID,
            $viewHidden
        );

        if (count($postData) < 1) {
            return NULL;
        }

        return $this->getVO($postData);
    }

    public function getThreadByRelativeCode(
        int  $relativeCode = 0,
        int  $sectionID    = 0,
        bool $viewHidden   = FALSE
    ) : PostVO
    {
        return $this->getByRelativeCode($relativeCode, TRUE, $sectionID, $viewHidden);
    }

    public function getByParentID(
        int  $parentID   = 0,
        bool $viewHidden = FALSE
    ) : array
    {
        $posts = $this->object->getPostsByParentID($parentID, $viewHidden);

        if (count($posts) < 1) {
            return [];
        }

        return $this->getVOArray($posts);
    }

    public function getCountByParentID(int $parentID = 0) : int
    {
        return $this->object->getCountPostsByParentID($parentID);
    }

    public function getBySectionID(
        int  $sectionID   = 0,
        int  $page        = 1,
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : array
    {
        $posts = $this->object->getPostsBySectionID(
            $sectionID,
            $page,
            $onlyThreads,
            $viewHidden
        );

        if (count($posts) < 1) {
            return [];
        }

        return $this->getVOArray($posts);
    }

    public function getCountBySectionID(
        int  $sectionID   = 0,
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : int
    {
        return $this->object->getCountPostsBySectionID(
            $sectionID,
            $onlyThreads,
            $viewHidden
        );
    }

    public function getThreadsBySectionID(
        int  $sectionID  = 0,
        int  $page       = 1,
        bool $viewHidden = FALSE
    ) : array
    {
        return $this->getThreadsBySectionID(
            $sectionID,
            $page,
            TRUE,
            $viewHidden
        );
    }

    public function getCountThreadsBySectionID(
        int  $sectionID  = 0,
        bool $viewHidden = FALSE
    ) : int
    {
        return $this->getCountBySectionID($sectionID, TRUE, $viewHidden);
    }

    public function search(string $keyword = '', int $page = 1) : array
    {
        if (strlen($keyword) < 3) {
            return [];
        }

        $posts = $this->object->getPostsByKeyword($keyword, $page);

        if (count($posts) < 1) {
            return [];
        }

        return $this->getVOArray($posts);
    }

    public function countSearch(string $keyword = '') : int
    {
        if (strlen($keyword) < 3) {
            return 0;
        }
        
        return $this->object->getPostsCountByKeyword($keyword);
    }

    public function create($formData, $isCheckCaptcha = TRUE) : array
    {
        if ($isCheckCaptcha && !$this->_checkCaptcha($formData)) {
            return [FALSE, 'Invalid Captcha Value'];
        }

        if (!$this->_validateFormDataFormat($formData)) {
            return [FALSE, 'Form Data Has Invalid Format'];
        }

        list(
            $username,
            $password,
            $makeTripCode,
            $sectionID,
            $threadID,
            $title,
            $text,
            $redirectType,
            $withoutMedia
        ) = $this->_getFormParams($formData);

        list($status, $errors) = $this->_validateFormData(
            $username,
            $password,
            $makeTripCode,
            $sectionID,
            $threadID,
            $title,
            $text,
            $redirectType,
            $withoutMedia
        );

        if (!$status) {
            return [FALSE, $errors];
        }

        list($mediaName, $mediaPath, $mediaType) = $this->_uploadMedia(
            $withoutMedia
        );

        $section = $this->initModel('section')->getByID($sectionID);

        $cryptPlugin = $this->initPlugin('crypt');
        $cryptConfig = $this->getConfig('crypt');

        if (!array_key_exists('salt', $cryptConfig)) {
            throw new Exception('Hash Salt Is Not Set');
        }

        $salt = $cryptConfig['salt'];

        $tripCode = $makeTripCode ? $cryptPlugin->makeTripCode($password) : '';

        if (strlen($password) > 0)
        {
            $password = $this->getHash($password, $salt);
        };
        
        $ipHash = $this->initModel('geoip')->getIPHash();

        $this->object->begin();

        try {
            $relativeCode = $this->object->getMaxPostRelativeCode(
                $section->getID()
            );

            $relativeCode++; 

            $status = $this->object->addPost(
                $relativeCode,
                $username,
                $password,
                $tripCode,
                $sectionID,
                $threadID,
                $title,
                $text,
                $mediaName,
                $mediaPath,
                $mediaType,
                $ipHash
            );

            if (!$status) {
                throw new Exception('Internal DB Error!');
            }
        } catch (Exception $exp) {
            $this->object->rollback();
            return [FALSE, $exp->getMessage()];
        }

        $this->object->commit();

        if ($redirectType === PostVO::REDIRECT_TYPE_SECTION) {
            $this->redirect('/'.$section->getSlug().'/');
        }

        if ($threadID > 0) {
            $relativeCode = $this->object->getRelativeCodeByID($threadID);
        }

        $this->redirect('/'.$section->getSlug().'/'.$relativeCode.'/#last');

    }

    public function remove(int $postID = 0) : bool
    {
        return $this->object->removePostByID($postID);
    }

    public function appendMetadata(PostVO $post = NULL) : PostVO
    {
        /*if(count($post)>0){
            $post['replies'] = $this->getReplies($post['relative_id'],$post['section_id']);
            $post['views'] = $this->getViews($post['id']);
            if(intval($post['parent_id'])<1){
                $post['posts'] = $this->getListByParentID($post['id']);
                $post['posts'] = array_reverse($post['posts']);
                $post['count_posts'] = count($post['posts']);
                $post['count_hidden_posts'] = $post['count_posts'] - 4;
                $post['count_hidden_posts'] = $post['count_hidden_posts']>0?$post['count_hidden_posts']:0;
                $post['recent_posts'] = [];
                if($post['count_hidden_posts'] > 0){
                    $post['recent_posts'] = array_slice($post['posts'],count(['posts'])-4,4);
                } else {
                    $post['recent_posts'] = $post['posts'];
                }
            }
            $post['created'] = date('d.m.Y',$post['created']).'&nbsp;'.date('H:i',$post['created']);
            $post['upd'] = date('d.m.Y',$post['upd']).'&nbsp;'.date('H:i',$post['upd']);
            $post['media_tag'] = '';
            if((
                $post['media_type_id'] == 2 ||
                $post['media_type_id'] == 3 ||
                $post['media_type_id'] == 4 ||
                $post['media_type_id'] == 5) &&
                strlen($post['media_path'])>0
            ){
                $post['media_path_preview'] = preg_replace('/^(.*?)\.(png|gif|jpg)$/su','$1-p.png',$post['media_path']);
                $post['media_path_thumbnail'] = preg_replace('/^(.*?)\.(png|gif|jpg)$/su','$1-thumb.gif',$post['media_path']);
                $post['media_tag'] = preg_match('/^(.*?)\.gif$/su',$post['media_path'])?'gif':$post['media_tag'];
            }
            if(
                $post['media_type_id'] == 5
            ){
                $post['youtube_id'] = explode('/',$post['media_path']);
                $post['youtube_id'] = end($post['youtube_id']);
                $post['youtube_id'] = preg_replace('/^(.*?)\.jpg$/su','$1', $post['youtube_id']);
                $post['youtube_id'] = trim($post['youtube_id']);
                $post['youtube_id'] = strlen($post['youtube_id'])>0?$post['youtube_id']:'';
            }
            $post['media_tag'] = $post['media_type_id']!=5?$post['media_tag']:'youtube';
            if(preg_match('/^(.*?)\[Link\:(.*?)\:\"(.*?)\"\](.*?)$/su',$post['text'])){
                $linkURL = preg_replace('/^(.*?)\[Link\:(.*?)\:\"(.*?)\"\](.*?)$/su','$2',$post['text']);
                $post['webLink'] = $this->getWebPageMetaData($linkURL);
            } else {
                $post['webLink'] = [];
            }
        }*/
        //To-Do
        return $post;
    }

    public function formatText(string $text = '') : string
    {
        /*$text = $this->parseLinkShortCode($post['text']);
        $text = $this->parseYoutubeShortCode($post['text']);
        $text = $this->normalizeText($post['text']);
        $text = $this->parseReplyShortCode($post['text'], $post['section_id']);
        $text = $this->markup2HTML($post['text']);*/
        // To-Do
        return $text;
    }

    private function _checkCaptcha(array $formData = []) : bool
    {
        //To-Do
        return FALSE;
    }

    private function _validateFormDataFormat(array $formData = []) : bool
    {
        return isset($formData['user_name']) &&
               isset($formData['passwod']) &&
               isset($formData['section_id']) &&
               isset($formData['thread_id']) &&
               isset($formData['title']) &&
               isset($formData['text']) &&
               isset($formData['redirect_type']) &&
               isset($formData['captcah']);
    }

    private function _validateFormData(
        string $username     = '',
        string $password     = '',
        bool   $makeTripCode = FALSE,
        int    $sectionID    = 0,
        int    $threadID     = 0,
        string $title        = '',
        string $text         = '',
        string $redirectType = '',
        bool   $withoutMedia = FALSE
    ) : array
    {
        list($status, $errors) = $this->_validateUsername($username);

        list($status, $errors) = $this->_validatePassword(
            $makeTripCode,
            $password
        );

        list($status, $errors) = $this->_validateSection($sectionID);
        list($status, $errors) = $this->_validateThread($threadID);
        list($status, $errors) = $this->_validateTitle($title);
        list($status, $errors) = $this->_validateText($text, $threadID);
        list($status, $errors) = $this->_validateRedirectType($redirectType);
        list($status, $errors) = $this->_validateMedia($withoutMedia);

        if ($this->_isPostEmpty($text, $withoutMedia)) {
            return [FALSE, 'Post Has Not Text Or Media'];
        }

        return [$status, $errors];
    }

    private function _validateUsername(string $username = '') : array
    {
        if (strlen($username) >= PostVO::MAX_USERNAME_LENGTH) {
            return [
                FALSE,
                'User Name Is Too Long! (More Than '.
                PostVO::MAX_USERNAME_LENGTH.' Characters)'
            ];
        }

        return [TRUE, NULL];
    }

    private function _validateSection(int $sectionID = 0) : array
    {
        $section = $this->initModel('section')->getByID($sectionID);

        if ($section == NULL) {
            return [FALSE, 'Invalid Section'];
        }

        if (
            $section->getStatus() != SectionVO::STATUS_ACTIVE &&
            $section->getStatus() != SectionVO::STATUS_HIDDEN
        ) {
            return [FALSE, 'You Can Not Post To This Section'];
        }

        return [TRUE, NULL];
    }

    private function _validateThread(int $threadID = 0) : array
    {
        if ($threadID < 1) {
            return [TRUE, NULL];
        }

        $thread = $this->getThreadByID($threadID);

        if ($thread == NULL) {
            return [FALSE, 'Thread Is Not Exists'];
        }
        
        if ($this->getCountByParentID($threadID) >= PostVO::MAX_REPLIES_COUNT) {
            return [FALSE, 'Thread Has Maximum Count Of Replies!'];
        }

        return [TRUE, NULL];
    }

    private function _validateTitle(string $title = '') : array
    {
        if (strlen($title) > PostVO::MAX_TITLE_LENGTH) {
            return [
                FALSE,
                'Title Is Too Long! (More Than '.
                PostVO::MAX_TITLE_LENGTH.' Characters)'
            ];
        }

        return [TRUE, NULL];
    }

    private function _validateText(string $text = '', int $threadID = 0) : array
    {
        if ($threadID < 1 && !strlen(trim($text)) > 0) {
            return [FALSE, 'Text Is Empty!'];
        }

        if (strlen($text) >= PostVO::MAX_TEXT_LENGTH) {
            return [
                FALSE,
                'Text Is Too Long! (More Than '.
                PostVO::MAX_TEXT_LENGTH.' Characters)'
            ];
        }

        return [TRUE, NULL];
    }

    private function _validatePassword(
        bool   $makeTripCode = NULL,
        string $password     = ''
    ) : array
    {
        if ($makeTripCode && strlen($password) < 1) {
            return [FALSE, 'Password Is Not Set'];
        }

        if (
            strlen($password) > 0 &&
            strlen($password) < PostVO::MIN_PASSWORD_LENGTH
        ) {
            return [FALSE, 'Password Is Too Short'];
        }

        return [TRUE, NULL];
    }

    private function _validateRedirectType(string $redirectType) : array
    {
        if (
            $redirectType != PostVO::REDIRECT_TYPE_SECTION &&
            $redirectType != PostVO::REDIRECT_TYPE_THREAD
        ) {
            return [FALSE, 'Invalid Redirect Type'];
        }

        return [TRUE, NULL];
    }

    private function _getFormParams(array $formData = []) : array
    {
        $makeTripCode = array_key_exists('make_trip_code', $formData);
        $withoutMedia = array_key_exists('without_media', $formData);

        return [
            (string) $formData['user_name'],
            (string) $formData['passwod'],
            $makeTripCode,
            (int)    $formData['section_id'],
            (int)    $formData['thread_id'],
            (string) $formData['title'],
            (string) $formData['text'],
            (string) $formData['redirect_type'],
            $withoutMedia
        ];
    }

    private function _validateMedia(bool $withoutMedia = FALSE) : array
    {
        if ($withoutMedia) {
            return [TRUE, NULL];
        }
        //To-Do
        return [FALSE, []];
    }

    private function _uploadMedia(bool $withoutMedia = FALSE) : array
    {
        //To-Do
        return [];
    }

    private function _isPostEmpty(
        string $text         = '',
        bool   $withoutMedia = FALSE
    ) : bool
    {
        //To-Do
        return TRUE;
    }
}
?>
