<?php
/**
 * Cron Controller Class
 */
class CronController extends CronControllerCore
{
    /**
     * Test Cron Job
     */
    public function jobTest() : void
    {
        $this->initPlugin('logger')->log('Cron Test Job Executed', 'test');
    }
}
?>
