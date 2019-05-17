<?php
/**
 * ValuesObject Class For Post Model
 */
class PostVO extends ValuesObject
{
    /**
     * @var int Count OF Last Children
     */
    const LAST_CHILDREN_COUNT = 4;

    /**
     * @var int Media Name Max Length
     */
    const MEDIA_NAME_MAX_LENGTH = 32;

    /**
     * @var int Max User Name Length
     */
    const MAX_USERNAME_LENGTH = 128;

    /**
     * @var int Max Title Length
     */
    const MAX_TITLE_LENGTH = 128;

    /**
     * @var int Max Text Length
     */
    const MAX_TEXT_LENGTH = 15000;

    /**
     * @var int Max Replies In Thread
     */
    const MAX_REPLIES_COUNT = 500;

    /**
     * @var int Minimal Password Length
     */
    const MIN_PASSWORD_LENGTH = 8;

    /**
     * @var string Redirect To Thread After Post Submit
     */
    const REDIRECT_TYPE_THREAD = 'thread';

    /**
     * @var string Redirect To Section After Post Submit
     */
    const REDIRECT_TYPE_SECTION = 'section';

    /**
     * Get Post ID
     *
     * @return int Post ID
     */
    public function getID() : int
    {
        return (int) $this->get('id');
    }

    /**
     * Get Post Relative ID
     *
     * @return int Post Relative ID
     */
    public function getRelativeCode() : int
    {
        return (int) $this->get('relative_code');
    }

    /**
     * Get Post Section ID
     *
     * @return string Post Section ID
     */
    public function getSectionID() : int
    {
        return (int) $this->get('id_section');
    }

    /**
     * Get Post Section Values Object
     *
     * @return SectionVO Post Section Values Object
     */
    public function getSection() : SectionVO
    {
        return $this->get('id_section');
    }

    /**
     * Get Parent Post ID
     *
     * @return int Parent Post ID
     */
    public function getParentID() : int
    {
        return (int) $this->get('id_parent');
    }

    /**
     * Get Parent Post
     *
     * @return PostVO Parent Post
     */
    public function getParent() : PostVO
    {
        return $this->get('parent');
    }

    /**
     * Get Children Post List
     *
     * @return array List Of Children Posts
     */
    public function getChildren() : array
    {
        return (array) $this->get('children');
    }

    /**
     * Get Last Children Post List
     *
     * @return array List Of Last Children Posts
     */
    public function getLastChildren() : array
    {
        $children = $this->getChildren();

        $lastChildren = array_slice(
            $children,
            count($children) - static::LAST_CHILDREN_COUNT - 1,
            static::LAST_CHILDREN_COUNT
        );

        $lastChildren = array_reverse($lastChildren);

        return $lastChildren;
    }

    /**
     * Get Post Title
     *
     * @return string Post Title
     */
    public function getTitle() : string
    {
        return (string) $this->get('title');
    }

    /**
     * Get Post Text
     *
     * @return string Post Text
     */
    public function getText() : string
    {
        return (string) $this->get('text');
    }

    /**
     * Get Post Media Path
     *
     * @return string Foo Param Value
     */
    public function getMediaPath() : string
    {
        $mediaPath = (string) $this->get('media_path');

        return $mediaPath;
    }

    /**
     * Get Post Media Path
     *
     * @return string Foo Param Value
     */
    public function getMediaAbsolutePath() : string
    {
        $mediaPath = $this->getMediaPath();

        if (!strlen($mediaPath) > 0) {
            return '';
        }

        return __DIR__.'/../../public'.$mediaPath;
    }

    /**
     * Get Post Media Name
     *
     * @return string Post Media Name
     */
    public function getMediaName() : string
    {
        $mediaName = (string) $this->get('media_name');

        if (!strlen($mediaName) > 0) {
            $mediaPath = $this->getMediaPath();

            $mediaName = explode('/', $mediaPath);
            $mediaName = end($mediaName);
            $mediaName = mb_convert_case($mediaName, MB_CASE_LOWER);
        }

        return $this->_prepareMediaName($mediaName);
    }

    /**
     * Get Post Media Type ID
     *
     * @return string Post Type ID
     */
    public function getMediaTypeID() : int
    {
        return (int) $this->get('id_media_type');
    }

    /**
     * Get Post Media Type
     *
     * @return string Post Media Type
     */
    public function getMediaType() : array
    {
        return (array) $this->get('media_type');
    }

    /**
     * Get Post Media Data
     *
     * @return array Post Media Data
     */
    public function getMedia() : array
    {
        return [
            'name'          => $this->getMediaName(),
            'type'          => $this->getMediaType(),
            'path'          => $this->getMediaPath(),
            'absolute_path' => $this->getMediaAbsolutePath()
        ];
    }

    /**
     * Get Post Password Hash
     *
     * @return string Post Password Hash
     */
    public function getPasswodHash() : string
    {
        return (string) $this->get('pswd_hash');
    }

    /**
     * Get Post User Name
     *
     * @return string Post User Name
     */
    public function getUsername() : string
    {
        if (!$this->has('username')) {
            return 'Anonymous';
        }

        return (string) $this->get('username');
    }

    /**
     * Get Post Tripcode
     *
     * @return string Post Tripcode
     */
    public function getTripcode() : string
    {
        return (string) $this->get('tripcode');
    }

    /**
     * Get Post User Session ID
     *
     * @return int Post User Session ID
     */
    public function getSessionID() : int
    {
        return (int) $this->get('id_session');
    }

    /**
     * Get Post User Session
     *
     * @return SessionVO Post User Session
     */
    public function getSession() : SessionVO
    {
        return $this->get('session');
    }

    /**
     * Get Is Active Post
     *
     * @return bool Is Post Active
     */
    public function getIsActive() : bool
    {
        return (bool) $this->get('is_active');
    }

    /**
     * Get Post Views
     *
     * @return int Post Views
     */
    public function getViews() : int
    {
        $views = (int) $this->get('views');

        return $views > 0 ? $views : 0;
    }

    /**
     * Get Post Creation Date
     *
     * @return string Post Creation Date
     */
    public function getCreateDate() : string
    {
        $cdate = (string) $this->get('cdate');

        return date('d.m.Y H:i:s', $cdate);
    }

    /**
     * Get Post Modify Date
     *
     * @return string Post Modify Date
     */
    public function getModifyDate() : string
    {
        $mdate = (string) $this->get('mdate');

        return date('d.m.Y H:i:s', $mdate);
    }

    /**
     * Get Post Sharing Data
     *
     * @return string Post Sharing Data
     */
    public function getSharing() : array
    {
        if (!$this->has('share')) {
            return [];
        }
        
        return (array) $this->get('share');
    }

    /**
     * Get List Of Cited Posts
     *
     * @return array List Of Cited Posts
     */
    public function getCitedPosts() : array
    {
        if (!$this->has('post_citation')) {
            return [];
        }
        
        return (array) $this->get('post_citation');
    }

    /**
     * Set Post Relative ID
     *
     * @param int $relativeCode Post Relative ID
     */
    public function setRelativeCode(int $relativeCode = 0) : void
    {
        $this->set('relative_code', $relativeCode);
    }

    /**
     * Set Post Section ID
     *
     * @param int $sectionID Post Section ID
     */
    public function setSectionID(int $sectionID = 0) : void
    {
        $this->set('id_section', $sectionID);
    }

    /**
     * Set Post Parent ID
     *
     * @param int $parentID Post Parent ID
     */
    public function setParentID(int $parentID = 0) : void
    {
        $this->set('id_parent', $parentID);
    }

    /**
     * Set Post Title
     *
     * @param string $title Post Title
     */
    public function setTitle(string $title = '') : void
    {
        $this->set('title', $title);
    }

    /**
     * Set Post Text
     *
     * @param string $text Post Text
     */
    public function setText(string $text = '') : void
    {
        $this->set('text', $text);
    }

    /**
     * Set Post Media Path
     *
     * @param string $mediaPath Post Media Path
     */
    public function setMediaPath(string $mediaPath = '') : void
    {
        $this->set('media_path', $mediaPath);
    }

    /**
     * Set Post Media Name
     *
     * @param string $mediaName Post Media Name
     */
    public function setMediaName(string $mediaName = '') : void
    {
        $mediaName = $this->_prepareMediaName($mediaName);

        $this->set('media_name', $mediaName);
    }

    /**
     * Set Post Media Type ID
     *
     * @param int $mediaTypeID Post Media Type ID
     */
    public function setMediaTypeID($mediaTypeID = 0) : void
    {
        $this->set('id_media_type', $mediaTypeID);
    }

    /**
     * Set Post Password Hash
     *
     * @param string $passwordHash Post Password Hash
     */
    public function setPasswodHash(string $passwordHash = '') : void
    {
        $this->set('pswd_hash', $passwordHash);
    }

    /**
     * Set Post User Name
     *
     * @param string $username Post User Name
     */
    public function setUsername($username = 'Anonymous') : void
    {
        $this->set('username', $username);
    }

    /**
     * Set Post Tripcode
     *
     * @param string $tripcode Post Tripcode
     */
    public function setTripcode($tripcode = '') : void
    {
        $this->set('tripcode', $tripcode);
    }

    /**
     * Set Post Session ID
     *
     * @param int $sessionID Post Session ID
     */
    public function setSessionID(int $sessionID = 0) : void
    {
        $this->set('id_session', $sessionID);
    }

    /**
     * Set Post Active Param
     *
     * @param bool $isActive Post Active Param Value
     */
    public function setIsActive(bool $isActive = TRUE) : void
    {
        $this->set('is_active', $isActive);
    }

    /**
     * Set Post Active
     */
    public function setActive() : void
    {
        $this->setIsActive(TRUE);
    }

    /**
     * Set Post Inactive
     */
    public function setInactive() : void
    {
        $this->setIsActive(FALSE);
    }

    /**
     * Set Post View
     */
    public function setView() : void
    {
        $views = $this->getViews();
        $views = $views++;

        $this->set('views', $views);
    }

    /**
     * Set Post Creation Date
     */
    public function setCreateDate() : void
    {
        $timestamp = time();

        if ($this->has('cdate')) {
            $timestamp = (int) $this->get('cdate');
        }

        $this->set('cdate', $timestamp);
    }

    /**
     * Set Post Modify Date
     */
    public function setModifyDate() : void
    {
        $this->set('mdate', time());
    }

    /**
     * Get Post Sharing Data
     *
     * @param array $share Post Share Data
     */
    public function setSharing(array $share = []) : void
    {
        $this->set('share', $share);
    }

    /**
     * Set List Of Cited Posts
     *
     * @param array $citedPosts List Of Cited Posts
     */
    public function setCitedPosts(array $citedPosts = []) : void
    {
        $this->set('post_citation', $citedPosts);
    }

    /**
     * Prepare Madia Name
     * 
     * @param string $mediaName Post Media Name
     * 
     * @return string Prepared Post Media Name
     */
    private function _prepareMediaName(string $mediaName = '') : string
    {
        if (!strlen($mediaName) > static::MEDIA_NAME_MAX_LENGTH) {
            return $mediaName;
        }

        if (static::MEDIA_NAME_MAX_LENGTH < 16) {
            throw new Exception('Constant MEDIA_NAME_MAX_LENGTH Has Bad Value');
        }

        $preparedMediaName = [];
        
        $preparedMediaName[] = substr(
            $mediaName,
            0,
            intdiv(static::MEDIA_NAME_MAX_LENGTH, 2)
        );

        $preparedMediaName[] = substr(
            $mediaName,
            strlen($mediaName) - intdiv(static::MEDIA_NAME_MAX_LENGTH, 2),
            intdiv(static::MEDIA_NAME_MAX_LENGTH, 2)
        );

        return implode('…', $preparedMediaName);
    }
}
?>
