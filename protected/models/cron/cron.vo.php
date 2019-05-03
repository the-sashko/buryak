<?php
/**
 * ValuesObject Class For Cron Model
 */
class CronVO extends ValuesObject
{
    /**
     * @var string Status For Cron Jobs That Waiting For Execution
     */
    const STATUS_WAITING = 'waiting';

    /**
     * @var string Status For Cron Jobs That Failed While Execution
     */
    const STATUS_FAILED = 'fail';

    /**
     * @var string Status For Cron Jobs That Successfully Executed
     */
    const STATUS_SUCCESS = 'success';

    /**
     * Get Cron Job ID
     *
     * @return int Cron Job ID
     */
    public function getID() : int
    {
        return (int) $this->get('id');
    }

    /**
     * Get Cron Job Action Value
     *
     * @return string Cron Job Action Value
     */
    public function getAction() : string
    {
        return (string) $this->get('action');
    }

    /**
     * Get Cron Job Execution Interval
     *
     * @return int Cron Job Execution Interval
     */
    public function getInterval() : int
    {
        return (int) $this->get('interval');
    }

    /**
     * Get Cron Job Next Execution Time
     *
     * @return int Cron Job Next Execution Time
     */
    public function getTimeNextExec() : int
    {
        return (int) $this->get('time_next_exec');
    }

    /**
     * Get Cron Job Last Execution Status
     *
     * @return int Cron Job Last Execution Status
     */
    public function getLastExecStatus() : int
    {
        return (int) $this->get('last_exec_status');
    }

    /**
     * Get Cron Job Error Message
     *
     * @return string Cron Job Error Message
     */
    public function getErrorMessage() : string
    {
        $lastExecStatus = (bool) $this->getLastExecStatus();
        $isActive       = (bool) $this->getIsActive();

        if (!$lastExecStatus && $isActive) {
            return (string) $this->get('error_message');
        }

        return '';
    }

    /**
     * Get Cron Job Status
     *
     * @return string Cron Job Status
     */
    public function getStatus() : string
    {
        $lastExecStatus = (bool) $this->getLastExecStatus();
        $isActive       = (bool) $this->getIsActive();

        if (!$isActive) {
            return static::STATUS_WAITING;
        }

        if (!$lastExecStatus) {
            return static::STATUS_FAILED;
        }

        return static::STATUS_SUCCESS;
    }

    /**
     * Get Cron Job Status Of Activation
     *
     * @return int Cron Job Status Of Activation
     */
    public function getIsActive() : int
    {
        return (int) $this->get('is_active');
    }

    /**
     * Set Cron Job Action
     *
     * @param string $action SCron Job Action
     *
     * @return bool Is Cron Job Execution Action Set
     */
    public function setAction(string $action = '') : bool
    {
        return $this->set('action', $action);
    }

    /**
     * Set Cron Job Execution Interval
     *
     * @param int $interval Cron Job Execution Interval
     *
     * @return bool Is Cron Job Execution Interval Set
     */
    public function setInterval(int $interval = -1) : bool
    {
        return $this->set('interval', $interval);
    }

    /**
     * Set Cron Job Next Execution Time
     *
     * @return bool Is Cron Job Next Execution Time Set
     */
    public function setTimeNextExec() : bool
    {
        $timeNextExec = time() + $this->getInterval();

        return $this->set('time_next_exec', $timeNextExec);
    }

    /**
     * Set Cron Job Last Execution Status
     *
     * @param int $statusCron Job Last Execution Status
     *
     * @return bool Is Cron Job Last Execution Status Set
     */
    public function setLastExecStatus(int $status = 0) : bool
    {
        return $this->set('last_exec_status', $status);
    }

    /**
     * Set Cron Job Activation Status
     *
     * @param int $isActive Cron Job Activation Status
     *
     * @return bool Is Cron Job Activation Status Set
     */
    public function setIsActive(int $isActive = 0) : bool
    {
        return $this->set('is_active', $isActive);
    }

    /**
     * Set Cron Job Error Message
     *
     * @param string $errorMessage Cron Job Error Message
     *
     * @return bool Is Cron Job Error Message Set
     */
    public function setErrorMessage(string $errorMessage = '') : bool
    {
        if (strlen(trim($errorMessage)) < 1) {
            return $this->set('error_message', '');
        }

        if (strlen($errorMessage) > 255) {
            $errorMessage = mb_substr($errorMessage, 0, 254).'…';
        }

        return $this->set('error_message', $errorMessage);
    }
}
?>
