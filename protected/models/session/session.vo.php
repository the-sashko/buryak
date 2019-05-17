<?php
/**
 * ValuesObject Class For Session Model
 */
class SessionVO extends ValuesObject
{
    /**
     * Get Session ID
     *
     * @return int Session ID
     */
    public function getID() : int
    {
        return (int) $this->get('id');
    }

    /**
     * Get Session Is Human Param Value
     *
     * @return bool Is Human Param Value
     */
    public function getIsHuman() : bool
    {
        return (bool) $this->get('is_human');
    }

    /**
     * Get Session Is Ban Param Value
     *
     * @return bool Is Ban Param Value
     */
    public function getIsBan() : bool
    {
        return (bool) $this->get('is_ban');
    }

    /**
     * Get Session User Data
     *
     * @return array User Data
     */
    public function getUserData() : array
    {
        $userData = $this->get('user_data');

        if (!strlen($userData) > 0) {
            return [];
        }

        return (array) json_decode($userData, true);
    }

    /**
     * Get Session Creation Date
     *
     * @return string Session Creation Date
     */
    public function getCreateDate() : string
    {
        $cdate = (string) $this->get('cdate');

        return date('d.m.Y H:i:s', $cdate);
    }

    /**
     * Get Session Modify Date
     *
     * @return string Session Modify Date
     */
    public function getModifyDate() : string
    {
        $mdate = (string) $this->get('mdate');

        return date('d.m.Y H:i:s', $mdate);
    }

    /**
     * Get Session List Of IP Addresses
     *
     * @return string List Of IP Addresses
     */
    public function getIPList() : array
    {
        return (array) $this->get('ip_list');
    }

    /**
     * Get Session Ban Meta Data
     *
     * @return array Session Ban Meta Data
     */
    public function getBanData() : array
    {
        if (!$this->getIsBan()) {
            return [];
        }

        if (!$this->has('ban')) {
            return [];
        }
        
        return (array) $this->get('ban');
    }

    /**
     * Get Session Ban Admin User ID
     *
     * @return int Admin ID Who Banned Current User
     */
    public function getBanAdminID() : int
    {
        $banData = $this->getBanData();

        if (!array_key_exists('id_admin', $banData)) {
            return -1;
        }

        return (int) $banData['id_admin'];
    }

    /**
     * Get Session Ban Admin User
     *
     * @return UserVO Admin Who Banned Current User
     */
    public function getBanAdmin() : UserVO
    {
        $banAdminID = $this->getBanAdminID();

        if ($banAdminID < 1) {
            return NULL;
        }

        $banData = $this->getBanData();

        if (!array_key_exists('id_admin', $banData)) {
            return NULL;
        }

        return $banData['admin'];
    }

    /**
     * Get Session Ban Expire Timestamp
     *
     * @return int Session Ban Expire Timestamp
     */
    public function getBanExpire() : int
    {
        $banData = $this->getBanData();

        if (!array_key_exists('expire', $banData)) {
            return -1;
        }

        return (int) $banData['expire'];
    }

    /**
     * Get Session Ban Expire Formatted Time
     *
     * @return string Session Ban Expire Formatted Time
     */
    public function getBanExpireFormatted() : string
    {
        $banExpire = $this->getBanExpire();

        if (!$banExpire > 0) {
            return '';
        }

        return date('d.m.Y H:i', $banExpire);
    }

    /**
     * Get Session Ban Message
     *
     * @return string Session Ban Message
     */
    public function getBanMessage() : string
    {

        $banData = $this->getBanData();

        if (!array_key_exists('message', $banData)) {
            return '';
        }
        
        return (string) $banData['message'];
    }

    /**
     * Get Session Ban Creation Date
     *
     * @return string Session Ban Creation Date
     */
    public function getBanCreateDate() : string
    {

        $banData = $this->getBanData();

        if (!array_key_exists('cdate', $banData)) {
            return '';
        }

        $cdate = (string) $banData['cdate'];

        return date('d.m.Y H:i:s', $cdate);
    }

    /**
     * Get Session Ban Modify Date
     *
     * @return string Session Ban Modify Date
     */
    public function getBanModifyDate() : string
    {
        $banData = $this->getBanData();

        if (!array_key_exists('mdate', $banData)) {
            return '';
        }

        $mdate = (string) $banData['mdate'];

        return date('d.m.Y H:i:s', $mdate);
    }

    /**
     * Set Session Is Human Param Value
     *
     * @param bool $isHuman Session Is Human Param Value
     */
    public function setIsHuman(bool $isHuman = TRUE) : void
    {
        $this->set('is_human', $isHuman);
    }

    /**
     * Set Session User As Human
     */
    public function setHuman() : void
    {
        $this->setIsHuman(TRUE);
    }

    /**
     * Set Session User As Not Human
     */
    public function setRobot() : void
    {
        $this->setIsHuman(FALSE);
    }

    /**
     * Set Session Is Ban Param Value
     *
     * @param bool $isBan Session Is Ban Param Value
     */
    public function setIsBan(bool $isBan = FALSE) : void
    {
        $this->get('is_ban', $isBan);
    }

    /**
     * Set Session User As Banned
     */
    public function setBanned() : void
    {
        $this->setIsBan(TRUE);
    }

    /**
     * Set Session User As Not Banned
     */
    public function setNotBanned() : void
    {
        $this->setIsBan(FALSE);
    }

    /**
     * Set Session User Data Value
     *
     * @param string $valueName Session User Data Value Name
     * @param string $valueData Session User Data Value Data
     */
    public function setUserData(
        string $valueName = '',
        string $valueData = ''
    ) : void
    {
        $userData             = $this->getUserData();
        $userData[$valueName] = $valueData;
        $userData             = json_encode($userData);

        $this->set('user_data', $userData);
    }

    /**
     * Set Session Creation Date
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
     * Set Session Modify Date
     */
    public function setModifyDate() : void
    {
        $this->set('mdate', time());
    }

    /**
     * Set Session User IP Address
     *
     * @param string $ip Session User IP Address
     */
    public function setIPList(string $ip = '0.0.0.0') : void
    {
        $ipList   = $this->get('ip_list');
        $ipList[] = $ip;
        $ipList   = array_uniqe($ipList);
        
        $this->set('ip_list', $ipList);
    }
}
?>
