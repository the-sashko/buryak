<?php
	/*
		class for sections
	*/
	class Section extends ModelCore {
		public function list(bool $viewHidden = false) : array {
			$isHidden = !$viewHidden?'`status_id`<>2':'1=1';
			$sql = "
				SELECT
					`id` AS 'id',
					`name` AS 'name',
					`title` AS 'title',
					`desription` AS 'desription',
					`default_user_name` AS 'default_user_name',
					`age_restriction` AS 'age_restriction',
					`status_id` AS 'status_id',
					`sort` AS 'sort'
				FROM `sections`
				WHERE {$isHidden}
				ORDER BY `sort` ASC;
			";
			return $this->select($sql,'section');
		}
		public function getBySlug(bool $viewHidden = true) : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`name` AS 'name',
					`title` AS 'title',
					`desription` AS 'desription',
					`default_user_name` AS 'default_user_name',
					`age_restriction` AS 'age_restriction'
				FROM `sections`
				WHERE
					`status_id` == 1 OR
					`status_id` == 2;
			";
			return $this->select($sql,'section');
		}
		public function create(string $name = '', string $title = '', string $desription = '', string $defaultUserName = '', int $ageRestriction = 0, int $statusID = 1, int $sort = 0) : array {
			$status = false;
			$err = [];
			$sql = "
				SELECT
					`id` AS 'id'
				FROM `sections`
				WHERE `name` = '{$name}';
			";
			$res = $this->select($sql,'section');
			if(count($res)>0 && is_array($res[0]) && isset($res[0]['id']) && intval($res[0]['id'])>0){
				$err[] = 'Duplicate section name!';
			}
			$sql = "
				SELECT
					`id` AS 'id'
				FROM `sections`
				WHERE `title` = '{$title}';
			";
			$res = $this->select($sql,'section');
			if(count($res)>0 && is_array($res[0]) && isset($res[0]['id']) && intval($res[0]['id'])>0){
				$err[] = 'Duplicate section title!';
			}
			if(count($err)<1){
				$sql = "
					INSERT INTO `sections` (
						`name`,
						`title`,
						`desription`,
						`default_user_name`,
						`age_restriction`,
						`status_id`,
						`sort`
					) VALUES (
						'{$name}',
						'{$title}',
						'{$desription}',
						'{$defaultUserName}',
						'{$ageRestriction}',
						'{$statusID}',
						'{$sort}'
					);
				";
				$res = $this->query($sql,'section');
				if(!$res){
					$err[] = 'Internal error!';
				}
				$status = $res;
			}
			return [$status,$err];
		}
	}
?>