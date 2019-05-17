<?php
/**
 * ModelObject Class For Post Model
 */
class PostObject extends ModelObjectCore
{
    /**
     * @var string Default Data Base Table
     */
    public $defaultTableName = 'posts';

    /**
     * @var string Data Base Table For Post Data
     */
    public $tablePosts = 'posts';

    /**
     * @var string Data Base Queries Post Scope
     */
    public $scope = 'post';

    /**
     * @var int Count Items On Page
     */
    public $itemsOnPage = 10;

    public function getAllPosts(
        int  $page        = 1,
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getCountAllPosts(
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : int
    {
        //TO-DO
        return 0;
    }

    public function getPostByID(
        int  $id         = 0,
        bool $onlyThread = FALSE,
        bool $viewHidden = FALSE
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getPostByRelativeCode(
        int  $relativeCode = 0,
        bool $onlyThread   = FALSE,
        int  $sectionID    = 0,
        bool $viewHidden   = FALSE
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getPostsByParentID(
        int  $id         = 0,
        bool $viewHidden = FALSE
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getCountPostsByParentID(int $id = 0) : int
    {
        //TO-DO
        return 0;
    }

    public function getPostsBySectionID(
        int  $sectionID   = 0,
        int  $page        = 0,
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getCountPostsBySectionID(
        int  $sectionID   = 0,
        bool $onlyThreads = FALSE,
        bool $viewHidden  = FALSE
    ) : int
    {
        //TO-DO
        return 0;
    }

    public function getPostsByKeyword(
        string $keyword = '',
        int    $page    = 1
    ) : array
    {
        //TO-DO
        return [];
    }

    public function getPostsCountByKeyword(string $keyword) : int
    {
        //TO-DO
        return 0;
    }

    public function getMaxPostRelativeCode(int $sectionID = 0) : int
    {
        //TO-DO
        return 0;
    }

    public function addPost(
        int    $relativeCode = 0,
        string $username     = '',
        string $password     = '',
        string $tripCode     = '',
        int    $sectionID    = 0,
        int    $threadID     = 0,
        string $title        = '',
        string $text         = '',
        string $mediaName    = '',
        string $mediaPath    = '',
        string $mediaType    = '',
        string $ipHash       = ''
    ) : bool
    {
        //TO-DO
        return FALSE;
    }

    public function getRelativeCodeByID(int $id = 0) : int
    {
        //TO-DO
        return 0;
    }

    public function removePostByID(int $id = 0) : bool
    {
        //TO-DO
        return FALSE;
    }
}
?>
