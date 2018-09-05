<?php
	/*
		Model of post
	*/
	class Post extends ModelCore{

		public $countOnPage = 10;

		public function getByID(int $id = 0, bool $viewHidden = false) : array {
			$where = "`id` = {$id}";
			$res = $this->getPosts($where,$viewHidden);
			if(
				count($res)>0 &&
				is_array($res[0]) &&
				count($res[0]) > 0
			){
				$res = $res[0];
			}
			return $res;
		}

		public function getByRelativeID(int $id = 0, bool $viewHidden = false) : array {
			$where = "`relative_id` = {$id}";
			$res = $this->getPosts($where,$viewHidden);
			if(
				count($res)>0 &&
				is_array($res[0]) &&
				count($res[0]) > 0
			){
				$res = $res[0];
			}
			return $res;
		}

		public function getListByParentID(int $id = 0, bool $viewHidden = false) : array {
			$where = "`parent_id` = {$id}";
			return $this->getPosts($where,$viewHidden);
		}

		public function getThreadByID(int $id = 0, bool $viewHidden = false) : array {
			$where = "
				`parent_id` = 0 AND
				`id` = {$id}
			";
			return $this->getPosts($where,$viewHidden);
		}

		public function getThreadByRelativeID(int $id = 0, bool $viewHidden = false) : array {
			$where = "
				`parent_id` = 0 AND
				`relative_id` = {$id}
			";
			return $this->getPosts($where,$viewHidden);
		}

		public function getPostList(int $sectionID = 0, int $page = 1, bool $viewHidden = false) : array {
			$where = $sectionID>0?"`section_id` = {$sectionID}":'1';
			$page = $page>0?$page:1;
			$limit = $this->countOnPage;
			$offset = ($page-1)*$limit;
			$limit = "
				LIMIT {$limit}
				OFFSET {$offset}";
			return $this->getPosts($where,$limit,$viewHidden);
		}

		public function getThreadList(int $sectionID = 0, int $page = 1, bool $viewHidden = false) : array {
			$where = $sectionID>0?"`section_id` = {$sectionID}":'1';
			$where = "
				{$where} AND
				`parent_id` = 0,
			";
			$page = $page>0?$page:1;
			$limit = $this->countOnPage;
			$offset = ($page-1)*$limit;
			$limit = "
				LIMIT {$limit}
				OFFSET {$offset}";
			return $this->getPosts($where,$limit,$viewHidden);
		}

		public function getPosts(string $where = '1', bool $viewHidden = false, string $limit = '') : array {
			$viewHidden = !$viewHidden?'`is_active` = 1':'1';
			$sql = "
				SELECT
					`id` AS 'id',
					`relative_id` AS 'relative_id',
					`section_id` AS 'section_id',
					`parent_id` AS 'parent_id',
					`title` AS 'title',
					`text` AS 'text',
					`media_path` AS 'media_path',
					`media_name` AS 'media_name',
					`media_type_id` AS 'media_type_id',
					`pswd` AS 'pswd',
					`username` AS 'username',
					`tripcode` AS 'tripcode',
					`created` AS 'created',
					`upd` AS 'upd',
					`ip` AS 'ip',
					`is_active` AS 'is_active'
				FROM `posts`
				WHERE
					{$viewHidden} AND
					{$where}
				ORDER BY `upd` DESC
				{$limit};
			";
			$posts = $this->select($sql,'post');
			return array_map([$this,'appendMetadata'], $posts);
		}

		public function getReplies(int $id = 0) : array {
			return [];
		}

		public function getViews(int $id = 0) : int {
			return 0;
		}

		public function setViews(int $id = 0) : bool {
			return true;
		}

		public function getMediaMetadata(int $id = 0) : array {
			return [];
		}

		public function countPosts(string $where = '1', bool $viewHidden = false) : int {
			$viewHidden = !$viewHidden?'`is_active` = 1':'1';
			$sql = "
				SELECT
					COUNT(`id`) AS 'count'
				FROM `posts`
				WHERE
					{$viewHidden} AND
					{$where};
			";
			$res = $this->select($sql,'post');
			if(
				count($res)>0 &&
				is_array($res[0]) &&
				isset($res[0]['count']) &&
				intval($res[0]['count']) > 0
			){
				return (int)$res[0]['count'];
			} else {
				return 0;
			}
		}

		public function getNewPostsByThreadID(int $threadID = 0, int $offsetPostID = 0, bool $viewHidden = false) : array {
			$where = "
				`parent_id` = {$threadID},
				`id` > {$offsetPostID}
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getNewPosts(int $sectionID = 0, int $offsetPostID = 0, bool $viewHidden = false) : array {
			$where = "
				`section_id` = {$sectionID},
				`id` > {$offsetPostID}
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getNewThreads(int $sectionID = 0, int $offsetPostID = 0, bool $viewHidden = false) : array {
			$where = "
				`section_id` = {$sectionID},
				`id` > {$offsetPostID},
				`parent_id` = 0
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function create() : bool {
			die('Comming soon...');
		}

		public function remove(int $id = 0) : bool {
			$sql = "
				DELETE FROM `post_citation`
				WHERE
					`post_from_id` = {$id} OR
					`post_to_id` = {$id};";
			$res = $this->query($sql,'post');
			$sql = "
				DELETE FROM `post_views`
				WHERE `post_id` = {$id};";
			$res = $this->query($sql,'post');
			$sql = "
				DELETE FROM `post_share`
				WHERE `post_id` = {$id};";
			$res = $this->query($sql,'post');
			$sql = "
				DELETE FROM `posts`
				WHERE `id` = {$id};";
			return $this->query($sql,'post');
		}

		public function appendMetadata(array $post = []) : array {
			if(count($post)>0){
				$post['replies'] = $this->getReplies($post['id']);
				$post['views'] = $this->getViews($post['id']);
				if(intval($post['parent_id'])<1){
					$post['posts'] = $this->getListByParentID($post['id']);
					$post['count_posts'] = count($post['posts']);
					$post['count_hidden_posts'] = $post['count_posts'] - 4;
					$post['count_hidden_posts'] = $post['count_hidden_posts']>0?$post['count_hidden_posts']:0;
					if($post['count_hidden_posts'] > 0){
						$post['recent_posts'] = 
					}
				}
				$post['created'] = date('d.m.Y H:i',$post['created']);
				$post['upd'] = date('d.m.Y H:i',$post['upd']);
				$post['media_metadata'] = $this->getMediaMetadata($post['id']);
			}
			return $post;
		}
	}
?>