<?php
/**
 * ModelCore Class For User Model
 */
class User extends ModelCore
{
    private $_idSession = null;

    private $_ip = null;

    private $_ipHash = null;

    private $_isHuman = true;

    private $_isBan = false;

    private $_userData = null;

    public function init(): void
    {
        $geoIpPlugin   = $this->getPlugin('geoIp');
        $this->_ip     = $geoIpPlugin->getIp();
        $this->_ipHash = $geoIpPlugin->getIpHash();

        $this->_setUserSession();
    }

    public function getIp(): string
    {
        return $this->_ip;
    }

    public function getIpHash(): string
    {
        return $this->_ipHash;
    }

    public function getSessionId(): int
    {
        $idSession = (int) $this->_idSession;

        if (empty($idSession)) {
            throw new UserException(
                UserException::MESSAGE_USER_SESSION_IS_NOT_SET,
                UserException::CODE_USER_SESSION_IS_NOT_SET
            );
        }

        return $idSession;
    }

    public function isHuman(): bool
    {
        return $this->_isHuman;
    }

    public function isBan(): bool
    {
        return $this->_isBan;
    }

    public function setHuman(): void
    {
        $this->_isHuman = true;
    }

    public function setNotHuman(): void
    {
        $this->_isHuman = false;
    }

    public function setBan(): void
    {
        $this->_isBan = true;
    }

    public function setNotBan(): void
    {
        $this->_isBan = false;
    }

    public function _getUserDataValue(?string $valueName = null)
    {
        if (empty($this->_userData)) {
            return null;
        }

        if (empty($valueName)) {
            return null;
        }

        if (array_key_exists($valueName, $this->_userData)) {
            return $this->_userData[$valueName];
        }

        return null;
    }

    public function _setUserDataValue(
        ?string $valueName = null,
                $valueData
    ): bool
    {
        if (empty($valueName)) {
            throw new UserException(
                UserException::MESSAGE_USER_DATA_VALUE_NAME_IS_NOT_SET,
                UserException::CODE_USER_DATA_VALUE_NAME_IS_NOT_SET
            );
        }

        $this->_userData[$valueName] = $valueData;

        if (empty($valueData)) {
            unset($this->_userData[$valueName]);
        }

        $this->object->updateSessionById($this->_userData, $this->_idSession);
    }

    private function _setUserSession(): void
    {
        $idSession = null;

        if (!$this->session->has('id_session')) {
            $idSession = $this->object->getIdSessionByIpHash($this->_ipHash);
        }

        if (empty($idSession)) {
            $idSession = (int) $this->session->get('id_session', $idSession);
        }

        $sessionRow = $this->object->getSesionById($idSession);

        if (empty($sessionRow)) {
            $sessionRow = [
                'is_human' => true,
                'is_ban'   => false,
                'data'     => []
            ];

            $idSession = $this->_createUserSession($sessionRow);
            $sessionRow = $this->object->getSesionById($idSession);
        }

        if (empty($idSession)) {
            throw new UserException(
                UserException::MESSAGE_USER_CAN_NOT_CREATE_SESSION,
                UserException::CODE_USER_CAN_NOT_CREATE_SESSION
            );
        }

        $this->_idSession = (int) $idSession;
        $this->_isHuman   = (bool) $sessionRow['is_human'];
        $this->_isBan     = (bool) $sessionRow['is_ban'];
        $this->_data      = (array) $sessionRow['data'];

        if (!$this->_isIpHashExists($idSession)) {
            $this->object->insertIpHash($idSession, $this->getIpHash());
        }

        $this->_idSession = $idSession;

        $this->session->set('id_session', $idSession);
    }

    private function _isIpHashExists(int $idSession): bool
    {
        $ipHash = $this->object->getIpHashByIdSession($idSession);

        if (empty($ipHash)) {
            return false;
        }

        return $ipHash == $this->_ipHash;
    }

    private function _createUserSession(array $sessionRow): ?int
    {
        $this->object->start();

        try {
            $sessionRow['data'] = json_encode($sessionRow['data']);

            if (!$this->object->insertSession($sessionRow)) {
                $this->object->rollback();
                return null;
            }

            $idSession = $this->object->getSessionMaxId();

            if (empty($idSession)) {
                $this->object->rollback();
                return null;
            }
        } catch (\Exception $exp) {
            $this->object->rollback();
            return null;
        }

        $this->object->commit();

        return $idSession;
    }
}
