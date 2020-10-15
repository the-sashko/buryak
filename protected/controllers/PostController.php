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
        //
    }

    public function actionThread(): void
    {
        //
    }

    public function actionBoard(): void
    {
        //
    }

    public function actionWrite(): void
    {
        $postModel = $this->getModel('post');

        $postForm = $postModel->write($this->post);

        if ($postForm->getStatus()) {
            die('OK!');
        }

        foreach ($postForm->getErrors() as $error) {
            echo '<h3>'.$error.'</h2>';
        }
    }

    public function actionRemove(): void
    {
        //
    }
}
