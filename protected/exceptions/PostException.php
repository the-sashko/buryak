<?php
class PostException extends AppException
{
    const CODE_POST_CONFIG_CRYPT_HAS_BAD_FORMAT = 1001;

    const MESSAGE_POST_CONFIG_CRYPT_HAS_BAD_FORMAT = 'Crypt Config Has Bad '.
                                                     'Format';
}
