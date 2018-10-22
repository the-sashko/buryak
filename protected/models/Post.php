<?php
	/*
		Model of post
	*/
	class Post extends ModelCore{

		use Image;
		use Markup;
		use Youtube;
		use Link;
		use Security;
		
		public $countOnPage = 10;

		public function getByID(int $id = 0, bool $viewHidden = false) : array {
			$where = "p.`id` = {$id}";
			$res = $this->getPosts($where,'',$viewHidden);
			if(
				count($res)>0 &&
				is_array($res[0]) &&
				count($res[0]) > 0
			){
				$res = $res[0];
			} else {
				$res = [];
			}
			return $res;
		}

		public function getByRelativeID(int $id = 0, int $sectionID = 0, bool $viewHidden = false) : array {
			$where = "
				p.`relative_id` = {$id} AND
				p.`section_id` = {$sectionID}
			";
			$res = $this->getPosts($where,'',$viewHidden);
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
			$where = "p.`parent_id` = {$id}";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getThreadByID(int $id = 0, bool $viewHidden = false) : array {
			$where = "
				p.`parent_id` = 0 AND
				p.`id` = {$id}
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getThreadByRelativeID(int $id = 0, int $sectionID = 0, bool $viewHidden = false) : array {
			$where = "
				p.`parent_id` = 0 AND
				p.`relative_id` = {$id} AND
				p.`section_id` = {$sectionID}
			";
			return $this->getPosts($where,'',$viewHidden);
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
				p.`parent_id` = 0
			";
			$page = $page>0?$page:1;
			$limit = $this->countOnPage;
			$offset = ($page-1)*$limit;
			$limit = "
				LIMIT {$limit}
				OFFSET {$offset}";
			return $this->getPosts($where,$limit,$viewHidden);
		}

		public function search(string $keyword = '', int $page = 1, bool $viewHidden = false) : array {
			$where = "
				p.`title` LIKE '%{$keyword}%' OR
				p.`text` LIKE '%{$keyword}%'
			";
			$page = $page>0?$page:1;9;
			$limit = $this->countOnPage;
			$offset = ($page-1)*$limit;
			$limit = "
				LIMIT {$limit}
				OFFSET {$offset}";
			return $this->getPosts($where,$limit,$viewHidden);
		}

		public function getPosts(string $where = '1', string $limit = '', bool $viewHidden = false) : array {
			$viewHidden = !$viewHidden?'p.`is_active` = 1':'1';
			$sql = "
				SELECT
					p.`id` AS 'id',
					p.`relative_id` AS 'relative_id',
					s.`id` AS 'section_id',
					s.`name` AS 'section_name',
					s.`title` AS 'section_title',
					p.`parent_id` AS 'parent_id',
					p.`title` AS 'title',
					p.`text` AS 'text',
					p.`media_path` AS 'media_path',
					p.`media_name` AS 'media_name',
					p.`media_type_id` AS 'media_type_id',
					p.`pswd` AS 'pswd',
					p.`username` AS 'username',
					p.`tripcode` AS 'tripcode',
					p.`created` AS 'created',
					p.`upd` AS 'upd',
					p.`ip` AS 'ip',
					p.`is_active` AS 'is_active'
				FROM `posts` AS p
				LEFT JOIN `sections` AS s ON s.`id` = p.`section_id`
				WHERE
					{$viewHidden} AND
					{$where}
				ORDER BY p.`upd` DESC
				{$limit};
			";
			$posts = $this->select($sql,'post');
			$posts = array_map([$this,'appendMetadata'], $posts);
			$posts = array_map([$this,'formatText'], $posts);
			return $posts;
		}

		public function getReplies(int $id = 0, int $sectionID = 0) : array {
			$id = $id>0?$id:0;
			$sql = "
				SELECT DISTINCT
					pc.`post_from_id` AS 'id'
				FROM `post_citation` AS pc
				WHERE
					pc.`post_to_id` = {$id} AND
					pc.`section_id` = {$sectionID};
			";
			$res = $this->select($sql,'post');
			$replies = [];
			foreach ($res as $reply){
				$id = is_array($reply)&&isset($reply['id'])?(int)$reply['id']:0;
				if($id>0){
					$replies[$id] = $id;
				}
			}
			sort($replies);
			return $replies;
		}

		public function getViews(int $id = 0) : int {
			return 0;
		}

		public function setViews(int $id = 0) : bool {
			return true;
		}

		public function getPostPageCount(int $sectionID = 0, bool $viewHidden = false) : int {
			$where = $sectionID>0?"`section_id` = {$sectionID}":'1';
			$countPosts = $this->countPosts($where,$viewHidden);
			$countPages = intval($countPosts/$this->countOnPage);
			if($countPages*$this->countOnPage<$countPosts){
				$countPages++;
			}
			return $countPages;
		}

		public function getThreadPageCount(int $sectionID = 0, bool $viewHidden = false) : int {
			$where = $sectionID>0?"p.`section_id` = {$sectionID}":'1';
			$where = "
				{$where} AND
				p.`parent_id` = 0
			";
			$countThreads = $this->countPosts($where,$viewHidden);
			$countPages = intval($countThreads/$this->countOnPage);
			if($countPages*$this->countOnPage<$countThreads){
				$countPages++;
			}
			return $countPages;
		}

		public function countPosts(string $where = '1', bool $viewHidden = false) : int {
			$viewHidden = !$viewHidden?'p.`is_active` = 1':'1';
			$sql = "
				SELECT
					COUNT(p.`id`) AS 'count'
				FROM `posts` AS p
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
				p.`parent_id` = {$threadID},
				p.`id` > {$offsetPostID}
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getNewPosts(int $sectionID = 0, int $offsetPostID = 0, bool $viewHidden = false) : array {
			$where = "
				p.`section_id` = {$sectionID},
				p.`id` > {$offsetPostID}
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function getNewThreads(int $sectionID = 0, int $offsetPostID = 0, bool $viewHidden = false) : array {
			$where = "
				p.`section_id` = {$sectionID},
				p.`id` > {$offsetPostID},
				p.`parent_id` = 0
			";
			return $this->getPosts($where,'',$viewHidden);
		}

		public function create(string $text = '', string $title = '', string $name = '', string $pswd = '', string $tripCode = '', string $userIP = '0.0.0.0', int $threadID = 0, int $sectionID = 0) : array {
			$status = false;
			$err = [];
			$created = time();
			if(strlen(trim($text))>0){
				$text = $this->normalizeSyntax($text);
				$text = $this->parseYoutubeID($text);
				$text = $this->parseLink($text);
				$text = $this->normalizeText($text);
			} else {
				$text = '';
			}
			$title = $this->normalizeText($title);
			$title = preg_replace('/\s+/su',' ',$title);
			$name = $this->normalizeText($name);
			$name = preg_replace('/\s+/su',' ',$name);
			$tripCode = trim($tripCode);
			$userIP = trim($userIP);
			$sql = "
				SELECT
					MAX(`relative_id`) AS 'id'
				FROM
					`posts`
				WHERE `section_id` = {$sectionID};
			";
			$res = $this->select($sql,'post');
			if(count($res)>0&&is_array($res[0])&&isset($res[0]['id'])&&intval($res[0]['id'])>0){
				$relativeID = (int)$res[0]['id'];
				$relativeID++;
			} else {
				$relativeID = 1;
			}
			if(
				isset($_FILES['media']) &&
				is_array($_FILES['media']) &&
				isset($_FILES['media']['tmp_name']) &&
				strlen($_FILES['media']['tmp_name']) > 0 &&
				isset($_FILES['media']['size']) &&
				intval($_FILES['media']['size']) > 0
			){
				$fileName = $_FILES['media']['name'];
				$fileSize = (int)$_FILES['media']['size'];
				$fileName = (string)mb_convert_case($fileName,MB_CASE_LOWER);
				$fileExt = explode('.',$fileName);
				$fileExt = end($fileExt);
				$fileExt = $fileExt!='jpeg'?$fileExt:'jpg';
				$fileName = preg_replace('/^(.*?)\.'.$fileExt.'$/su','$1',$fileName);
				$fileType = -1;
				$fileTypeGroup = '';
				$sql = "
					SELECT
						`id` AS 'id',
						`title` AS 'title',
						`group` AS 'group',
						`file_extention` AS 'file_extention'
					FROM `dictionary_media_types`;
				";
				$mediaTypeList = $this->select($sql,'dictionary');
				foreach ($mediaTypeList as $mediaType) {
					if(
						strlen($mediaType['file_extention'])>0 &&
						$mediaType['file_extention'] == $fileExt
					){
						$fileType = (int)$mediaType['id'];
						$fileTypeGroup = $mediaType['group'];
					}
				}
				if(!$fileType>0){
					$err[] = 'File has bad extention!';
				} else {
					if($fileSize > 30 * 1024 * 1024){
						$err[] = 'File size is so large (> 30Mb)!';
					} else {
						$fileTitle = strlen($fileName)>0?$fileName:'image';
						$fileName = "{$fileTitle}.{$fileExt}";
						$fileTitle = "{$fileSize}_{$fileTitle}";
						$realFileName = "{$fileSize}_{$fileName}";
						if($fileSize < 1024){
							$fileSize = "{$fileSize}b";
						} elseif($fileSize < 1024*1024) {
							$fileSize = intval($fileSize/1024);
							$fileSize = "{$fileSize}Kb";
						} elseif($fileSize < 1024*1024*1024) {
							$fileSize = intval($fileSize/(1024*1024));
							$fileSize = "{$fileSize}Mb";
						} elseif($fileSize < 1024*1024*1024*1024) {
							$fileSize = intval($fileSize/(1024*1024*1024));
							$fileSize = "{$fileSize}Gb";
						}else{
							$fileSize = intval($fileSize/(1024*1024*1024*1024));
							$fileSize = "{$fileSize}Tb";
						}
						$fileDir = $fileTypeGroup.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.date('H').'/'.date('i').'/'.date('s');
						$res = mkdir(getcwd().'/../media/'.$fileDir,0755,true);
						$filePath = "{$fileDir}/{$realFileName}";
						if($res){
							$res = move_uploaded_file($_FILES['media']['tmp_name'],getcwd().'/../media/'.$filePath);
							if($res){
								chmod(getcwd().'/../media/'.$filePath,0755);
								if(
									$fileExt = 'jpg' ||
									$fileExt = 'png' ||
									$fileExt = 'gif'
								){
									$this->imageLoad($realFileName,$fileTitle,getcwd().'/../media/'.$fileDir);
									$this->imageGen(['thumbnail','post']);
									$fileName = "{$fileName} ({$fileSize})";
								}
							} else {
								$err[] = 'Can not save file on server!';
							}
						} else {
							$err[] = 'Can not create folder (for saving file) on server!';
						}
					}
				}
			} else {
				$fileType = 1;
				$fileName = '';
				$filePath = '';
			}
			if($fileType==1){
				if(preg_match('/(.*?)\[Youtube\:(.*?)\](.*?)/su',$text)){
					$youtubeID = preg_replace('/(.*?)\[Youtube\:(.*?)\](.*?)/su','$2',$text);
					$image = $this->getVideoThumbnail($youtubeID);
					if(strlen($image)>0){
						$fileDir = 'img/'.date('Y').'/'.date('m').'/'.date('d').'/'.date('H').'/'.date('i').'/'.date('s');
						$res = mkdir(getcwd().'/../media/'.$fileDir,0755,true);
						copy($image,getcwd()."/../media/{$fileDir}/{$youtubeID}.jpg");
						$fileTitle = "{$youtubeID}";
						$this->imageLoad("{$youtubeID}.jpg",$fileTitle,getcwd().'/../media/'.$fileDir);
						$this->imageGen(['thumbnail','post']);
						$videoMetaData = $this->getVideoMetaData($youtubeID);
						$fileType = 5;
						$fileName = isset($videoMetaData['title'])&&strlen($videoMetaData['title'])?$this->escapeInput($videoMetaData['title']):'Youtube video';
						$filePath = "{$fileDir}/{$youtubeID}.jpg";
					}
				}
			}
			if(count($err)<1){
				$sql = "
					INSERT INTO `posts` (
						`relative_id`,
						`section_id`,
						`parent_id`,
						`title`,
						`text`,
						`media_path`,
						`media_name`,
						`media_type_id`,
						`pswd`,
						`username`,
						`tripcode`,
						`created`,
						`upd`,
						`ip`,
						`is_active`,
						`is_hidden`
					) VALUES (
						{$relativeID},
						{$sectionID},
						{$threadID},
						'{$title}',
						'{$text}',
						'{$filePath}',
						'{$fileName}',
						{$fileType},
						'{$pswd}',
						'{$name}',
						'{$tripCode}',
						{$created},
						{$created},
						'{$userIP}',
						1,
						0
					);
				";
				$status = $this->query($sql,'post');
				if(!$status){
					$err = count($err)>0?$err:['Internal error!'];
				} else{
					if($threadID>0){
						$sql = "
							UPDATE `posts`
							SET
								`upd` = {$created}
							WHERE `id` = {$threadID};
						";
						$this->query($sql,'post');
					}
					preg_match_all('/\[Reply\:([0-9]+)\]/su',$text,$postCitationIDArr);
					$postCitationIDArr = is_array($postCitationIDArr)&&isset($postCitationIDArr[1])&&is_array($postCitationIDArr[1])?$postCitationIDArr[1]:[];
					$postCitationIDArr = array_unique($postCitationIDArr);
					foreach ($postCitationIDArr as $postToID){
						$postToID = (int)$postToID;
						if($postToID>0){
							$sql = "
								INSERT INTO `post_citation` (
									`post_from_id`,
									`post_to_id`,
									`section_id`
								) VALUES (
									{$relativeID},
									{$postToID},
									{$sectionID}
								);
							";
							$this->query($sql,'post');
						}
					}
				}
			}
			return [$status,$err];
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
				$post['replies'] = $this->getReplies($post['relative_id'],$post['section_id']);
				$post['views'] = $this->getViews($post['id']);
				if(intval($post['parent_id'])<1){
					$post['posts'] = $this->getListByParentID($post['id']);
					$post['posts'] = array_reverse($post['posts']);
					$post['count_posts'] = count($post['posts']);
					$post['count_hidden_posts'] = $post['count_posts'] - 4;
					$post['count_hidden_posts'] = $post['count_hidden_posts']>0?$post['count_hidden_posts']:0;
					$post['recent_posts'] = [];
					if($post['count_hidden_posts'] > 0){
						$post['recent_posts'] = array_slice($post['posts'],count(['posts'])-4,4);
					} else {
						$post['recent_posts'] = $post['posts'];
					}
				}
				$post['created'] = date('d.m.Y',$post['created']).'&nbsp;'.date('H:i',$post['created']);
				$post['upd'] = date('d.m.Y',$post['upd']).'&nbsp;'.date('H:i',$post['upd']);
				$post['media_tag'] = '';
				if((
					$post['media_type_id'] == 2 ||
					$post['media_type_id'] == 3 ||
					$post['media_type_id'] == 4 ||
					$post['media_type_id'] == 5) &&
					strlen($post['media_path'])>0
				){
					$post['media_path_preview'] = preg_replace('/^(.*?)\.(png|gif|jpg)$/su','$1-p.png',$post['media_path']);
					$post['media_path_thumbnail'] = preg_replace('/^(.*?)\.(png|gif|jpg)$/su','$1-thumb.gif',$post['media_path']);
					$post['media_tag'] = preg_match('/^(.*?)\.gif$/su',$post['media_path'])?'gif':$post['media_tag'];
				}
				if(
					$post['media_type_id'] == 5
				){
					$post['youtube_id'] = explode('/',$post['media_path']);
					$post['youtube_id'] = end($post['youtube_id']);
					$post['youtube_id'] = preg_replace('/^(.*?)\.jpg$/su','$1', $post['youtube_id']);
					$post['youtube_id'] = trim($post['youtube_id']);
					$post['youtube_id'] = strlen($post['youtube_id'])>0?$post['youtube_id']:'';
				}
				$post['media_tag'] = $post['media_type_id']!=5?$post['media_tag']:'youtube';
				if(preg_match('/^(.*?)\[Link\:(.*?)\:\"(.*?)\"\](.*?)$/su',$post['text'])){
					$linkURL = preg_replace('/^(.*?)\[Link\:(.*?)\:\"(.*?)\"\](.*?)$/su','$2',$post['text']);
					$post['webLink'] = $this->getWebPageMetaData($linkURL);
				} else {
					$post['webLink'] = [];
				}
			}
			return $post;
		}

		public function formatText(array $post = []) : array {
			if(count($post)>0){
				$post['text'] = $this->parseLinkShortCode($post['text']);
				$post['text'] = $this->parseYoutubeShortCode($post['text']);
				$post['text'] = $this->normalizeText($post['text']);
				$post['text'] = $this->parseReplyShortCode($post['text'],$post['section_id']);
				$post['text'] = $this->markup2HTML($post['text']);
			}
			return $post;
		}
	}
?>