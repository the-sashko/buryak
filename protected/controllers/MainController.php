<?php
/**
 * Main Controller Class
 */
class MainController extends ControllerCore
{
    /**
     * @var string Template Scope
     */
    public $templaterScope = 'dafault';

    /**
     * Default Site Action
     */
    public function actionIndex() : void
    {
        $this->render('example');
    }
}
?>
