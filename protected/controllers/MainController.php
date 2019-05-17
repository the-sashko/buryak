<?php
class MainController extends ControllerCore
{
    public function actionPage() : void
    {
        $staticPage = $this->getStaticPage($this->URLParam);

        $this->render('staticPage', [
            'staticPage' => $staticPage
        ]);
    }

    public function actionError() : void
    {
        $code = (int) $this->URLParam;

        if ($code < 400 && $code > 526) {
            $this->redirect('/error/404/', TRUE);
        }

        http_response_code($code);

        $this->render('error', [
            'code' => $code
        ]);
    }       
}
?>
