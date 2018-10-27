<?php
	/*
		Class for cron jobs
	*/
	class Cron extends ModelCore{
		public function getActions() : array {
			$actionList = [];
			if(is_file(getcwd().'/../protected/controllers/CronController.php')){
				include_once(getcwd().'/../protected/controllers/CronController.php');
				if(class_exists('CronController')){
					$actionList = get_class_methods('CronController');
					foreach ($actionList as $actionIDX => $actionItem) {
						if(!preg_match('/^job([A-Z])([a-z]+)$/su',$actionItem)){
							unset($actionList[$actionIDX]);
						} else {
							$reflection = new ReflectionMethod('CronController', $actionItem);
							if(!$reflection->isPublic()){
								unset($actionList[$actionIDX]);
							}
						}
					}
				}
			}
			return $actionList;
		}
		public function addJob(string $action = '', int $timeValue = 1, int $typeID = 1) : bool {
			$timeValue = $timeValue>0?$timeValue:1;
			$typeID = $typeID>0?$typeID:1;
			$timeNextExec = strtotime(date('Y-m-d H:i:00',time()))+60;
			$sql = "
				INSERT INTO `cron_jobs` (
					`action`,
					`time_value`,
					`time_next_exec`,
					`type_id`
				) VALUES (
					'{$action}',
					'{$timeValue}',
					'{$timeNextExec}',
					'{$typeID}'
				);
			";
			return $this->query($sql,'cron');
		}
		public function getJobs(bool $displayAll = true) : array {
			$where = !$displayAll?'WHERE cj.`time_next_exec` <= '.time():'';
			$sql = "
				SELECT
					cj.`id` AS 'id',
					cj.`action` AS 'action',
					cj.`time_value` AS 'time_value',
					cj.`time_next_exec` AS 'next_exec',
					dct.`id` AS 'type_id',
					dct.`title` AS 'type_title',
					dct.`value` AS 'type_value'
				FROM `cron_jobs` AS cj
				LEFT JOIN `dictionary_cron_types` AS dct ON cj.`type_id` = dct.`id`
				{$where};
			";
			return $this->select($sql,'cron');
		}
		public function UPDJobDate(int $id = 0, int $timeNextExec = 0) : bool {
			$sql = "
				UPDATE `cron_jobs`
				SET `time_next_exec` = {$timeNextExec}
				WHERE `id` = {$id};
			";
			return $this->query($sql,'cron');
		}
	}
?>
