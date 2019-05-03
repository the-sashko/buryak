<?php
/**
 * ModelObject Class For Cron Model
 */
class CronObject extends ModelObjectCore
{
    /**
     * @var string Default Data Base Table
     */
    public $defaultTableName = 'cron_jobs';

    /**
     * @var string Data Base Table For Cron Jobs Data
     */
    public $tableCrons = 'cron_jobs';

    /**
     * @var string Data Base Queries Cache Scope
     */
    public $scope = 'cron';

    /**
     * Insert Cron Job Data To Data Base
     *
     * @param array $values Cron Job Data
     *
     * @return bool Is Cron Job Data Successfully Saved
     */
    public function create(array $values = []) : bool
    {
        $columns = [
            'action',
            'interval',
            'is_active'
        ];

        return $this->insert($this->tableCrons, $columns, $values);
    }

    /**
     * Update Cron Job Data In Data Base By Job ID
     *
     * @param array $columns Cron Job Columns In Data Base Table
     * @param array $values  Cron Job Data
     * @param int   $id      Cron Job ID
     *
     * @return bool Is Cron Job Data Successfully Updated
     */
    public function updateCronByID(
        array  $columns = [],
        array  $values  = [],
        int    $id      = -1
    ) : bool
    {
        return $this->updateByID($this->tableCrons, $columns, $values, $id);
    }

    /**
     * Get All Cron Jobs
     *
     * @return array List Of All Cron Jobs
     */
    public function getAllCrons() : array
    {
        return $this->getAll($this->tableCrons);
    }

    /**
     * Get Cron Jobs For Execution
     *
     * @return array List Of All Cron Jobs For Execution
     */
    public function getJobs() : array
    {
        $condition = '"time_next_exec" <= '.time().' AND "is_active" = true';
        return $this->getAllByCondition($this->tableCrons, [], $condition);
    }
}
?>
