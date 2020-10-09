<?php
/**
 * Cron Controller Class
 */
class CronController extends CronControllerCore
{
    /**
     * Test Cron Job
     */
    public function jobTest(): void
    {
        $this->getPlugin('logger')->log('Cron Test Job Executed', 'test');
    }
}
