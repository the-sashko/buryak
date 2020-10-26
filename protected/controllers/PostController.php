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

        if ($postForm->isStatusSuccess()) {
            $this->redirect($postForm->getRedirectUrl());
        }

        $this->session->setFlash('post_form_data', $postForm->exportRow());
        $this->session->setFlash('post_form_errors', $postForm->getErrors());
        $this->redirect($postForm->getFormUrl());
    }

    public function actionRemove(): void
    {
        //
    }
}
