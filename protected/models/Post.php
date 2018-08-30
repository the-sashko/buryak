<?php
	/*
		Model of post
	*/
	class Post extends ModelCore{

		public function getByID(int $id = 0) : array {
			die('Comming soon...');
		}

		public function plainList(int $page = 1) : array {
			die('Comming soon...');
		}

		public function plainListByThreadID(int $id = 0, int $offsetID = 0, int $count = 0) : array {
			die('Comming soon...');
		}

		public function getThread(int $id = 0) : array {
			die('Comming soon...');
		}

		public function getThreadList(int $sectionID = 0, int $page = 1) : array {
			die('Comming soon...');
		}

		public function create() : bool {
			die('Comming soon...');
		}

		public function remove(int $id = 0) : bool {
			die('Comming soon...');
		}

		public function appendMetadata(array $post = []) : array {
			die('Comming soon...');
		}
	}
?>