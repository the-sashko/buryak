<?php
/**
 * ModelObject Class For Example Model
 */
class ExampleObject extends ModelObjectCore
{
    /**
     * @var string Default Data Base Table
     */
    public $defaultTableName = 'example';

    /**
     * @var string Data Base Table For Example Data
     */
    public $tableExample = 'example';

    /**
     * @var string Data Base Queries Cache Scope
     */
    public $scope = 'example';

    /**
     * Geting Data From Example Table
     *
     * @return array List Of Example Data
     */
    public function getAllExamples() : array
    {
        return $this->getAll($this->tableExample);
    }
}
?>
