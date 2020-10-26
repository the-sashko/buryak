<?php
/**
 * Cron Controller Class
 */
class CronController extends CronControllerCore
{
    public function jobCaptcha(): void
    {
        $cryptConfig = $this->getConfig('crypt');

        if (
            !array_key_exists('salt', $cryptConfig) ||
            empty($cryptConfig['salt'])
        ) {
            //to-do
        }

        $cryptSalt = (string) $cryptConfig['salt'];

        $captchaSettings = [
            'data_dir_path' => __DIR__.'/../res/captcha',
            'hash_salt'     => $cryptSalt
        ];

        $captchaPlugin = $this->getPlugin('captcha');
        $captchaPlugin->setSettings($captchaSettings);
        $captchaPlugin->cron();

        // to-do: remove old files
    }
}
