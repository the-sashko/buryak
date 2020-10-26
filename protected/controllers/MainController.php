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

        if ($this->session->hasFlash('post_form_errors')) {
            $formErrors = $this->session->getFlash('post_form_errors');
        }

        if ($this->session->hasFlash('post_form_data')) {
            $formData = $this->session->getFlash('post_form_data');
        }

        $this->render(
            'main',
            [
                'formErrors' => (array) $formErrors,
                'formData'   => (array) $formData
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
