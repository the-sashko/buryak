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
     * Default Site Action
     */
    public function actionIndex(): void
    {
        $this->render('main');
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
