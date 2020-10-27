<?php
/**
 * Post Controller Class
 */
class PostController extends ControllerCore
{
    /**
     * @var string Template Scope
     */
    public $templaterScope = 'site';

    public function actionIndex(): void
    {
        //to-do
    }

    public function actionThread(): void
    {
        //To-do
    }

    public function actionBoard(): void
    {
        $sectionSlug = $this->getValueFromUrl('board');

        if (empty($sectionSlug)) {
            $this->redirect('/error/404/');
        }

        $section = $this->getModel('section')->getVOBySlug($sectionSlug);

        if (empty($section)) {
            $this->redirect('/error/404/');
        }

        $formData   = null;
        $formErrors = null;

        $captchaEntity = $this->_getCaptchaEntity();

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
                'captchaImageUrl' => $captchaEntity->getImageUrlPath(),
                'section'         => $section
            ]
        );
    }

    public function actionWrite(): void
    {
        $postModel = $this->getModel('post');

        $postForm = $postModel->write($this->post);

        if ($postForm->isStatusSuccess()) {
            $this->redirect($postForm->getRedirectUrl());
        }

        $this->session->setFlash('post_form_data', $postForm->exportRow());
        $this->session->setFlash('post_form_errors', $postForm->getErrors());
        $this->redirect($postForm->getFormUrl());
    }

    public function actionRemove(): void
    {
        //To-do
    }

    private function _getCaptchaEntity():
        Core\Plugins\Captcha\Classes\CaptchaEntity
    {
        $cryptConfig = $this->getConfig('crypt');

        if (
            !array_key_exists('salt', $cryptConfig) ||
            empty($cryptConfig['salt'])
        ) {
            throw new PostException(
                PostException::CODE_POST_CONFIG_CRYPT_HAS_BAD_FORMAT,
                PostException::MESSAGE_POST_CONFIG_CRYPT_HAS_BAD_FORMAT
            );
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

        return $captchaEntity;
    }
}
