<?php
class SectionController extends ControllerCore
{
    public function actionThreads() : void
    {
        $slug = $this->URLParam;

        if ($slug == 'all') {
            $posts = $this->initModel('post')->getAllThreads($this->page);

            if (count($posts) < 1 && $this->page !== 1) {
                $this->page --;
                $this->redirect('/'.$slug.'/page-'.$this->page.'/');
            }

            $this->render('section/all',[
                'posts'   => $posts
            ]);
        }

        $section = $this->initModel('section')->getBySlug();

        if ($section == NULL) {
            $this->redirect('/error/404/');
        }

        $posts = $this->initModel('post')->getBySectionID(
            $section->getID(),
            $this->page
        );

        if (count($posts) < 1 && $this->page !== 1) {
            $this->page --;
            $this->redirect('/'.$slug.'/page-'.$this->page.'/');
        }

        $this->render('section/single',[
            'section' => $section,
            'posts'   => $posts
        ]);
    }
}
?>
