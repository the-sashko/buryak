<?php
class UserException extends AppException
{
    const CODE_USER_CAN_NOT_CREATE_SESSION     = 1001;
    const CODE_USER_DATA_VALUE_NAME_IS_NOT_SET = 1002;
    const CODE_USER_SESSION_IS_NOT_SET         = 1003;

    const MESSAGE_USER_CAN_NOT_CREATE_SESSION = 'Can Not Create User Session';

    const MESSAGE_USER_DATA_VALUE_NAME_IS_NOT_SET = 'User Model Data Value '.
                                                    'Name Is Not Set';

    const MESSAGE_USER_SESSION_IS_NOT_SET = 'User Session Is Not Set';
}
