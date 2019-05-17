<?php
class User extends ModelCore
{
    public function getAll(int $page = 1) : array
    {
        $users = $this->object->getAllUsers($page);

        if (count($users) < 1) {
            return NULL;
        }

        return $this->getVOArray($users);
    }

    public function getCountAll() : int
    {
        return $this->object->getCountAllUsers();
	}

    public function getUserByID(int $userID = 0) : UserVO
    {
        $userData = $this->object->getUserByID($userID);

        if (count($userData) < 1) {
            return NULL;
        }

        return $this->getVO($userData);
	}

    public function getUserByLogin(string $login = '') : UserVO
    {
        $userData = $this->object->getUserByLogin($login);

        if (count($userData) < 1) {
            return NULL;
        }

        return $this->getVO($userData);
	}

    public function create($formData) : array
    {
        if (!$this->_validateFormDataFormat($formData)) {
            return [FALSE, 'Form Data Has Invalid Format'];
        }

        list($name, $email, $role, $isActive) = $this->_getFormParams(
			$formData
		);

        list($status, $errors) = $this->_validateFormData($name, $email, $role);

        if (!$status) {
            return [FALSE, $errors];
		}
		
		$status = $this->object->addUser($name, $email, $role, $isActive);
		
		if (!$status) {
			throw new Exception('Internal DB Error!');
		}

		return [TRUE, NULL];
    }

    public function remove(int $userID = 0) : bool
    {
        return $this->object->removePostByID($userID);
	}

    private function _validateFormDataFormat(array $formData = []) : bool
    {
        return isset($formData['name']) &&
               isset($formData['email']) &&
               isset($formData['role']) &&
               isset($formData['is_active']);
    }

    private function _validateFormData(
		string $name  = '',
		string $email = '',
		string $role  = ''
	) : array
    {
        list($status, $errors) = $this->_validateName($name);
        list($status, $errors) = $this->_validateEmail($name);
		list($status, $errors) = $this->_validateRole($name);

		return [$status, $errors];
    }

    private function _validateName(string $name = '') : array
    {
        if (strlen($name) > UserVO::MAX_NAME_LENGTH) {
            return [
                FALSE,
                'Name Is Too Long! (More Than '.
                PostVO::MAX_NAME_LENGTH.' Characters)'
            ];
        }

        return [TRUE, NULL];
	}

    private function _validateEmail(string $email = '') : array
    {
        //To-Do

		return [FALSE, []];
	}

    private function _getFormParams(array $formData = []) : array
    {
        $isActive = array_key_exists('is_active', $formData);

        return [			
			(string) $formData['name'],
			(string) $formData['email'],
			(string) $formData['role'],
            $isActive
        ];
    }
}
?>
