<?php
/**
 * ModelCore Class For Cron Model
 */
class Cron extends ModelCore implements ModelCRUD
{
    use CronForm;

    /**
     * Get All Cron Jobs
     *
     * @return array List Of All Cron Jobs
     */
    public function getAll() : array
    {
        $crons = $this->object->getAllCrons();
        return $this->getVOArray($crons);
    }

    /**
     * Get Cron Jobs For Execution
     *
     * @return array List Of Jobs For Execution
     */
    public function getJobs() : array
    {
        $jobs = $this->object->getJobs();
        return $this->getVOArray($jobs);
    }

    /**
     * Check Is Cron Job Exisits By Action And Execution Interval
     *
     * @param string $action   Cron Job Action
     * @param int    $interval Cron Job Execution Interval
     *
     * @return bool Is Cron Job Exists
     */
    private function _isCronExists(
        string $action   = '',
        int    $interval = -1
    ) : bool
    {
        // To-Do

        return FALSE;
    }

    /**
     * Create New Cron Job
     *
     * @param string $action   Cron Job Action
     * @param int    $interval Cron Job Execution Interval
     * @param bool   $isActive Is Cron Job Active
     *
     * @return bool Is Cron Job Successfully Created
     */
    private function _create(
        string $action   = '',
        int    $interval = -1,
        bool   $isActive = FALSE
    ) : bool
    {
        return $this->object->create([
            $action,
            $interval,
            $isActive
        ]);
    }

    /**
     * Update Cron Job Data By Cron ID
     *
     * @param string $action   Cron Job Action
     * @param int    $interval Cron Job Execution Interval
     * @param bool   $isActive Is Cron Job Active
     * @param int    $cronID   Cron Job ID
     *
     * @return bool Is Cron Job Successfully Updated
     */
    private function _updateByID(
        string $action   = '',
        int    $interval = -1,
        bool   $isActive = FALSE,
        int    $cronID   = -1
    ) : bool
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

    /**
     * Update Cron Job By Cron Job Values Object Data
     *
     * @param object $cronVO Instance Of CronVO
     *
     * @return bool Is Cron Job Successfully Updated
     */
    public function updateByVO(CronVO $cronVO = NULL) : bool
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
?>
