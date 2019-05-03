<?php
	/*
		Class for dictionaries
	*/
	class Dictionary extends ModelCore{
		public function getAdminRoles() : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`title` AS 'title'
				FROM `dictionary_admin_roles`;
			";
			return $this->select($sql,'dictionary');
		}
		public function getSectionStatuses() : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`title` AS 'title'
				FROM `dictionary_section_statuses`;
			";
			return $this->select($sql,'dictionary');
		}
		public function getMediaTypes() : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`title` AS 'title',
					`group` AS 'group',
					`file_extention` AS 'file_extention'
				FROM `dictionary_media_types`;
			";
			return $this->select($sql,'dictionary');
		}
		public function getShareTypes() : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`title` AS 'title'
				FROM `dictionary_share_types`;
			";
			return $this->select($sql,'dictionary');
		}
		public function getCronTypes() : array {
			$sql = "
				SELECT
					`id` AS 'id',
					`title` AS 'title',
					`value` AS 'value'
				FROM `dictionary_cron_types`;
			";
			return $this->select($sql,'dictionary');
		}
	}
?>
