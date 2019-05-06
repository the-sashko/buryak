<?php
class MainController extends ControllerCore
{
    public function actionAllposts() : void
    {
        $this->initModel('post');

        $allPosts = (new Post)->getPostList(0, $this->page);

        if (count($allPosts) < 1 && $this->page !== 1) {
            $this->page --;
            $this->redirect('/page-'.$this->page.'/');
        }

        $this->render('main', [
            'posts'      => $allPosts,
            'isMainPage' => TRUE,
            'ajaxLoad'   => TRUE,
            'ajaxAction' => 'postlist'
        ]);
    }

    public function actionPage() : void
    {
        if (
            !strlen($slug) > 0 &&
            !file_exists(
                getcwd()."/../protected/res/static_pages/{$slug}.txt"
            ) &&
            !is_file(getcwd()."/../protected/res/static_pages/{$slug}.txt") &&
        ){
            $this->redirect('/error/404/');
        }

        $pageData = file_get_contents(
            getcwd()."/../protected/res/static_pages/{$slug}.txt"
        );

        $pageData = explode("\n===\n", $pageData);

        if(count($pageData)>1){
            $pageTitle = $pageData[0];
            $pageText = $pageData[1];
            $pageText = $this->normalizeSyntax($pageText);
            $pageText = $this->parseLink($pageText);
            $pageText = $this->parseLinkShortCode($pageText);
            $pageText = $this->parseYoutubeID($pageText);
            $pageText = $this->parseYoutubeShortCode($pageText);
            $pageText = $this->normalizeText($pageText);
            $pageText = $this->markup2HTML($pageText);

            $this->commonData['pageTitle'] = $pageTitle;

            $this->commonData['URLPath'] = [
                0 => [
                    'url'   => '#',
                    'title' => $pageTitle
                ]
            ];

            $this->render('page', [
                'staticPageText' => $pageText
            ]);
        }
    }

    public function actionOptions() : void
    {
        //To-Do
    }

    public function actionError() : void
    {
        if ($code < 400 && $code > 526) {
            $this->header('/error/404/', TRUE);
        }

        $this->commonData['pageTitle'] = "Error {$code}";

        $this->commonData['URLPath'] = [
            0 => [
                'url'   => "/error/{$code}/",
                'title' => "Error {$code}"
            ] 
        ];

        http_response_code($code);

        $this->render('error', [
            'code' => $code
        ]);
    }

    public function actionBan() : void
    {
        //To-Do
    }

    public function actionCaptcha() : void
    {
        //To-Do
    }       
}
?>
