<?php
/**
 * ValuesObject Class For User Model
 */
class UserVO extends ValuesObject
{
    /**
     * @var string Admin Role
     */
    const ROLE_ADMIN = 'admin';

    /**
     * @var string Moderator Role
     */
    const ROLE_MODERATOR = 'moderator';

    /**
     * @var int Max Name Length
     */
    const MAX_NAME_LENGTH = 32;

    /**
     * Get User ID
     *
     * @return int User ID
     */
    public function getID() : int
    {
        if ($this->has('id')) {
            return -1;
        }

        return (int) $this->get('id');
    }

    /**
     * Get User Name
     *
     * @return string User Name
     */
    public function getName() : string
    {
        if ($this->has('name')) {
            return NULL;
        }

        return (string) $this->get('name');
    }

    /**
     * Get User Email
     *
     * @return string User Email
     */
    public function getEmail() : string
    {
        if ($this->has('email')) {
            return NULL;
        }

        return (string) $this->get('email');
    }

    /**
     * Get User Passsword Hash
     *
     * @return string User Password Hash
     */
    public function getPasswordHash() : string
    {
        if ($this->has('pswd_hash')) {
            return NULL;
        }

        return (string) $this->get('pswd_hash');
    }

    /**
     * Get User Role
     *
     * @return string User Role
     */
    public function getUserRole() : string
    {
        if ($this->has('role')) {
            return NULL;
        }

        return (string) $this->get('role');
    }

    /**
     * Get User Is Active Value
     *
     * @return bool User Is Active Value
     */
    public function getIsActive() : bool
    {
        if ($this->has('is_active')) {
            return NULL;
        }

        return (bool) $this->get('is_active');
    }

    /**
     * Get User Is Admin
     *
     * @return bool User Is Admin
     */
    public function getIsAdmin() : bool
    {
        return $this->has('id');
    }

    /**
     * Get User Session
     *
     * @return SessionVO User Session Data
     */
    public function getSession() : SessionVO
    {
        if (!$this->has('session')) {
            return NULL;
        }

        return $this->get('session');
    }

    /**
     * Get User Sections
     *
     * @return array List Of User Sections
     */
    public function getSections() : array
    {
        if (!$this->has('sections')) {
            return [];
        }

        return (array) $this->get('sections');
    }

    /**
     * Set User Name
     *
     * @param string $name User Name
     */
    public function setName(string $name = '') : void
    {
        $this->set('name', $name);
    }

    /**
     * Set User Email
     *
     * @param string $name User Email
     */
    public function setEmail(string $email = '') : void
    {
        $this->set('email', $email);
    }

    /**
     * Set User Password Hash
     *
     * @param string $pswdHash User Password Hash
     */
    public function setPasswordHash(string $pswdHash = '') : void
    {
        $this->set('pswd_hash', $pswdHash);
    }

    /**
     * Set User Role
     *
     * @param string $name User Role
     */
    public function setRole(string $role = '') : void
    {
        $this->set('role', $role);
    }

    /**
     * Set User Role Admin
     */
    public function setRoleAdmin() : void
    {
        $this->set('role', static::ROLE_ADMIN);
    }

    /**
     * Set User Role Moderator
     */
    public function setRoleModerator() : void
    {
        $this->set('role', static::ROLE_MODERATOR);
    }

    /**
     * Set User Is Active Value
     *
     * @param bool $isActive User Is Active Value
     */
    public function setIsActive(bool $isActive = TRUE) : void
    {
        $this->set('is_active', $isActive);
    }

    /**
     * Set User Active
     */
    public function setActive() : void
    {
        $this->setIsActive(TRUE);
    }

    /**
     * Set User Inactive
     */
   public function setInactive() : void
   {
        $this->setIsActive(FALSE);
   }
}
?>
