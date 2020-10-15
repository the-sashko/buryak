<?php
class CronObject extends ModelObjectCore
{
    public $defaultTableName = 'cron_jobs';
    public $tableCrons       = 'cron_jobs';
    public $scope            = 'cron';

    /**
     * summary
     */
    public function create(?array $values = null): bool
    {
        $columns = [
            'action',
            'interval',
            'is_active'
        ];

        return $this->insert($this->tableCrons, $columns, $values);
    }

    /**
     * summary
     */
    public function updateCronByID(
        ?array  $columns = null,
        ?array  $values  = null,
        ?int    $id      = null
    ): bool
    {
        return $this->updateByID($this->tableCrons, $columns, $values, $id);
    }

    /**
     * summary
     */
    public function getAllCrons(): array
    {
        return $this->getAll($this->tableCrons);
    }

    /**
     * summary
     */
    public function getJobs(): array
    {
        $condition = '"time_next_exec" <= '.time().' AND "is_active" = true';
        return $this->getAllByCondition($this->tableCrons, null, $condition);
    }
}
