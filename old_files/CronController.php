<?php
	/*
		Controller for cron jobs
	*/
	class CronController extends ControllerCore {

		public function default() : void {
			$this->redirect('/',301);
		}

		public function actionRun() : void {
			$this->initModel('Cron');
			$cron = new Cron();
			foreach($cron->getJobs(false) as $job){
				$jobAction = $job['action'];
				$timeNextExec = time()+intval($job['time_value'])*intval($job['type_value']);
				if($cron->UPDJobDate($job['id'],$timeNextExec)){
					$this->$jobAction($job['id']);
				}
			}
		}

		public function jobShare() : void {
			;
		}

		public function jobSitemap() : void {
			;
		}

		public function jobTest() : void {
			echo 'test';
		}
	}
?>
