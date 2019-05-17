<?php
/**
 * ModelObject Class For User Model
 */
class UserObject extends ModelObjectCore
{
    /**
     * @var string Default Data Base Table
     */
    public $defaultTableName = 'users';

    /**
     * @var string Data Base Table For User Data
     */
    public $tableUsers = 'users';

    /**
     * @var string Data Base Queries User Scope
     */
    public $scope = 'user';

    public function getAllUsers(int $page = 1) : array
    {
        //To-Do
        return [];
    }

    public function getCountAllUsers() : int
    {
        //To-Do
        return 0;
    }

    public function getUserByID(int $userID = 0) : int
    {
        //To-Do
        return 0;
    }

    public function getUserByLogin(string $login = '') : array
    {
        //To-Do
        return [];
    }

    public function addUser(
        string $name     = '',
        string $email    = '',
        string $role     = '',
        bool   $isActive = FALSE
    ) : bool
    {
        //To-Do
        return FALSE;
    }

    public function removePostByID(int $userID = 0) : bool
    {
        //To-Do
        return FALSE;
    }
}
?>
