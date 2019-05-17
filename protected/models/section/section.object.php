<?php
/**
 * ModelObject Class For Section Model
 */
class SectionObject extends ModelObjectCore
{
    /**
     * @var string Default Data Base Table
     */
    public $defaultTableName = 'sections';

    /**
     * @var string Data Base Table For Sections
     */
    public $tableSections = 'sections';

    /**
     * @var string Data Base Queries Sections Scope
     */
    public $scope = 'sections';

    /**
     * @var int Count Items On Page
     */
    public $itemsOnPage = 25;

    public function getAllSection(
        int  $page       = 1,
        bool $viewHidden = FALSE
    ) : array
    {
        //To-Do
        return [];
    }

    public function getCountAllSection(bool $viewHidden = FALSE) : int
    {
        //To-Do
        return 0;
    }

    public function getSectionByID(
        int  $sectionID  = 1,
        bool $viewHidden = FALSE
    ) : array
    {
        //To-Do
        return [];
    }

    public function getSectionBySlug(
        string $sectionSlug = '',
        bool   $viewHidden  = FALSE
    ) : array
    {
        //To-Do
        return [];
    }

    public function addSection(
        string $slug           = '',
        string $title          = '',
        string $desription     = '',
        int    $ageRestriction = 0,
        string $status         = '',
        int    $sort           = 0
    ) : bool
    {
        //To-Do
        return FALSE;
    }

    public function removeSectionByID(int $sectionID = 0) : bool
    {
        //To-Do
        return FALSE;
    }

}
?>
