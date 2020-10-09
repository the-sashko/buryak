<?php
class Cron extends ModelCore implements IModelCRUD
{
    use CronForm;

    public function getAll(): array
    {
        $crons = $this->object->getAllCrons();
        return $this->getVOArray($crons);
    }

    public function getJobs(): array
    {
        $jobs = $this->object->getJobs();
        return $this->getVOArray($jobs);
    }

    protected function _isCronExists(
        ?string $action   = null,
        ?int    $interval = null
    ): bool
    {
        // To-Do

        return false;
    }

    protected function _create(
        ?string $action  = null,
        ?int   $interval = null,
        bool   $isActive = false
    ): bool
    {
        return $this->object->create([
            $action,
            $interval,
            $isActive
        ]);
    }

    protected function _updateByID(
        ?string $action   = null,
        ?int    $interval = null,
        bool    $isActive = false,
        ?int    $cronID   = null
    ): bool
    {
        return $res = $this->object->updateCronByID([
            'action',
            'interval',
            'isActive'
        ], [
            $action,
            $interval,
            $isActive
        ], $cronID);
    }

    public function updateByVO(?CronVO $cronVO = null): bool
    {
        return $res = $this->object->updateCronByID([
            'action',
            'interval',
            'time_next_exec',
            'last_exec_status',
            'is_active',
            'error_message'
        ], [
            $cronVO->getAction(),
            $cronVO->getInterval(),
            $cronVO->getTimeNextExec(),
            $cronVO->getLastExecStatus(),
            $cronVO->getIsActive(),
            $cronVO->getErrorMessage()
        ], $cronVO->getID());
    }
}
