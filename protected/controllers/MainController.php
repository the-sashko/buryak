<?php
/**
 * Main Controller Class
 */
class MainController extends ControllerCore
{
    /**
     * @var string Template Scope
     */
    public $templaterScope = 'site';

    /**
     * Main Ppage
     */
    public function actionIndex(): void
    {
        $formData   = null;
        $formErrors = null;

        $cryptConfig = $this->getConfig('crypt');

        if (
            !array_key_exists('salt', $cryptConfig) ||
            empty($cryptConfig['salt'])
        ) {
            //to-do
        }

        $cryptSalt = (string) $cryptConfig['salt'];

        if (
            !file_exists(__DIR__.'/../res/captcha') ||
            !is_dir(__DIR__.'/../res/captcha')
        ) {
            mkdir(__DIR__.'/../res/captcha', 0775, true);
        }

        $captchaSettings = [
            'data_dir_path'      => __DIR__.'/../res/captcha',
            'hash_salt'          => $cryptSalt,
            'image_url_template' => '/media/captcha/',
            'language'           => $this->language
        ];

        $captchaPlugin = $this->getPlugin('captcha');
        $captchaPlugin->setSettings($captchaSettings);
        $captchaEntity = $captchaPlugin->getEntity();

        $this->session->setFlash('captcha_hash', $captchaEntity->getHash());

        if ($this->session->hasFlash('post_form_errors')) {
            $formErrors = $this->session->getFlash('post_form_errors');
        }

        if ($this->session->hasFlash('post_form_data')) {
            $formData = $this->session->getFlash('post_form_data');
        }

        $this->render(
            'main',
            [
                'formErrors'      => (array) $formErrors,
                'formData'        => (array) $formData,
                'captchaImageUrl' => $captchaEntity->getImageUrlPath()
            ]
        );
    }

    /**
     * Site Action For Static Pages
     */
    public function actionPage(): void
    {
        $this->displayStaticPage();
    }

    /**
     * Site Action For Error Pages
     */
    public function actionError(): void
    {
        $this->displayErrorPage();
    }
}
