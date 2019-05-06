<?php
class SectionController extends ControllerCore
{
    public function actionList() : void
    {
        if (count($params) != 2) {
            $this->redirect('/error/404/');
        }

        $sectionName = (string) $params[0];
        $sectionPage = (int) $params[1];

        if ($sectionPage < 1) {
            $this->redirect("/{$section['name']}/", TRUE);
        }

        $this->initModel('section');
        $this->initModel('post');

        if ($sectionName != 'all') {
            $section = (new Section)->getByName($sectionName);
            if (count($section) < 1) {
                $this->redirect('/error/404/');
            }
            $description = $section['description'];
            $sectionSlug = $section['name'];
            $posts = (new Post)->getThreadList($section['id'],$sectionPage);
            if($sectionPage > 1 && count($posts) < 1){
                $this->redirect("/{$section['name']}/");
            }                
            $postPageCount = (new Post)->getThreadPageCount($section['id']);
            if($sectionPage>1){
                $this->commonData['URLPath'] = [
                    0 => [
                        'url' => '#',
                        'title' => "Page: {$sectionPage}"
                    ],
                    1 => [
                        'url' => "/{$section['name']}/",
                        'title' => $section['title']
                    ]
                ];
            } else {
                $this->commonData['URLPath'] = [
                    0 => [
                        'url' => '#',
                        'title' => $section['title']
                    ]
                ];
            }
            $this->commonData['pageTitle'] = $sectionPage>1?"{$section['title']} (page {$sectionPage})":"{$section['title']}";
        } else {
            $section = [];
            $description = 'threads from all sections';
            $sectionSlug = 'all';
            $posts = (new Post)->getThreadList(0,$sectionPage);
            if(count($posts)<1){
                $this->redirect('/');
            }
            $postPageCount = (new Post)->getThreadPageCount(0);
            if($sectionPage>1){
                $this->commonData['URLPath'] = [
                    0 => [
                        'url' => '#',
                        'title' => "Page: {$sectionPage}"
                    ],
                    1 => [
                        'url' => '/all/',
                        'title' => 'All threads'
                    ]
                ];
            } else {
                $this->commonData['URLPath'] = [
                    0 => [
                        'url' => '/all/',
                        'title' => 'All threads'
                    ]
                ];
            }
            $this->commonData['pageTitle'] = $sectionPage>1?"All threads (page {$sectionPage})":"All threads";
        }
        $this->render('section',[
            'isAllSections' => $sectionName == 'all',
            'section' => $section,
            'description' => $description,
            'posts' => $posts,
            'sectionSlug' => $sectionSlug,
            'pageCount' => $postPageCount,
            'currPage' => $sectionPage
        ]);
    }

    public function actionThread() : void
    {
        if(count($params)==2){
            $sectionName = $params[0];
            $threadID = (int)$params[1];
            if($threadID>0){
                $this->initModel('section');
                $section = (new Section)->getByName($sectionName);
                if(count($section)>0){
                    $this->initModel('post');
                    $post = new Post();
                    $threadPost = $post->getByRelativeID($threadID,$section['id']);
                    if(count($threadPost)>0){
                        if(intval($threadPost['parent_id'])>0){
                            $realThreadPost = $post->getByID($threadPost['parent_id']);
                            if(count($threadPost)>0){
                                $this->redirect("/{$sectionName}/{$realThreadPost['relative_id']}/#post-{$threadID}",301);
                            } else {
                                $this->redirect('/error/404/');
                            }
                        }
                        $threadReplies = $post->getListByParentID($threadPost['id']);
                        $threadReplies = array_reverse($threadReplies);
                        $threadMaxReplyID = -1;
                        if(count($threadReplies)>0){
                            $threadMaxReplyID = end($threadReplies)['id'];
                        }
                        $this->commonData['pageTitle'] = strlen($threadPost['title'])>1?$threadPost['title']:"Thread #{$threadPost['relative_id']}";
                        $this->commonData['URLPath'] = [
                            0 => [
                                'url' => "/{$section['name']}/",
                                'title' => $section['title']
                            ],
                            1 => [
                                'url' => '#',
                                'title' => strlen($threadPost['title'])>1?$threadPost['title']:"Thread #{$threadPost['relative_id']}"
                            ]
                        ];
                        $this->render('thread',[
                            'threadID' => $threadPost['id'],
                            'threadMaxReplyID' => $threadMaxReplyID,
                            'section' => $section,
                            'originalPost' => $threadPost,
                            'posts' => $threadReplies
                        ]);
                    }
                }
            }
        }
        $this->redirect('/error/404/');
    }
}
?>
