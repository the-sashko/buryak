<?php
/**
 * Authentication/Authorization Model
 */

class Auth extends ModelCore implements IModelAuth
{
    /**
     * @var object User Model Instance
     */
	public $user = NULL;

	public function __construct()
	{
		parent::__construct();

		$this->user = $this->initModel('user');
	}

    /**
     * Check Login And Password
     *
     * @param string $login    User Login
     * @param string $password User Password
     *
     * @return array Are Login And Password Valid
     */
    public function checkLoginAndPassword(
        string $login    = '',
        string $password = ''
	) : void
	{
		//To-Do
	}

    /**
     * Sign In By Login And Password
     *
     * @param string $login    User Login
     * @param string $password User Password
     *
     * @return bool Is User Successfully Signed In
     */
    public function signinByLoginAndPassword(
        string $login    = '',
        string $password = ''
	) : void
	{
		//To-Do
	}

    /**
     * Check Is User Signed In
     *
     * @return bool Is User Signed In
     */
	public function isSignedIn() : bool
	{
		return FALSE; //To-Do
	}

    /**
     * Signed Out User
     *
     * @return bool Is User Successfully Signed Out
     */
	public function signout() : bool
	{
		return FALSE; //To-Do
	}

    /**
     * Ban User
     * 
     * @return bool Is User Successfully Added To Ban
     */
	public function add2ban() : bool
	{
		return FALSE; //To-Do
	}

    /**
     * Remove User From
     * 
     * @return bool Is User Successfully Removed From Ban
     */
	public function removeFromBan() : bool
	{
		return FALSE; //To-Do
	}

    /**
     * Check Is User Banned
     * 
     * @return bool Is User Banned
     */
	public function isBanned() : bool
	{
		return FALSE; //To-Do
	}

    /**
     * Check Authentication Token
     *
     * @param string $authToken Authentication Token
     *
     * @return bool Is Authentication Token Valid
     */
	public function checkToken(string $authToken = '') : bool
	{
        throw new Exception('Method Is Not Impemented');

		return FALSE;
	}

    /**
     * Sign In By Auth Token
     *
     * @param string $authToken Authentication Token
     *
     * @return bool Is User Successfully Signed In
     */
	public function signInByToken(string $authToken = '') : bool
	{
        throw new Exception('Method Is Not Impemented');

		return FALSE;
	}
}
?>
