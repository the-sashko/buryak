<?php
	trait Youtube {
		public function parseYoutubeID(string $text = '') : string {
			$text = preg_replace('/^(.*?)(https|http)\:\/\/(m\.youtube|www\.youtube|youtube)\.com\/watch(\s)(.*?)$/su','$1https://www.youtube.com$4$5',$text);
			$text = preg_replace('/^(.*?)(https|http)\:\/\/(m\.youtube|www\.youtube|youtube)\.com\/watch$/su','$1https://www.youtube.com$4',$text);


			$text = preg_replace('/^(.*?)(https|http)\:\/\/(m\.youtu|www\.youtu|youtu)\.be\/(\s)(.*?)$/su','$1https://www.youtube.com$4$5',$text);
			$text = preg_replace('/^(.*?)(https|http)\:\/\/(m\.youtu|www\.youtu|youtu)\.be\/$/su','$1https://www.youtube.com$4',$text);

			if(
				preg_match('/^(.*?)(https|http)\:\/\/(m\.youtube|www\.youtube|youtube)\.com\/watch(.*?)$/su',$text)
			){
				$idVideo = '';
				$timeVideo = '';
				$link = preg_replace('/(.*?)(https|http)\:\/\/(m\.youtube|www\.youtube|youtube)\.com\/watch(.*?)(\s(.*?)$|$)/su','$2://$3.com/watch$4',$text);
				$linkParts = explode('#',$link)[0];
				$linkParts = explode('?',$linkParts);
				$linkParts = end($linkParts);
				$linkParts = explode('/',$linkParts);
				$linkParts = end($linkParts);
				$linkParts = explode('&',$linkParts);
				foreach ($linkParts as $linkPart) {
					$linkPart = explode('=',$linkPart);
					if(count($linkPart)>1){
						if($linkPart[0]=='v'&&strlen($linkPart[1])>0){
							$idVideo = $linkPart[1];
						}
						if($linkPart[0]=='t'&&strlen($linkPart[1])>0){
							$timeVideo = $linkPart[1];
						}
					}
				}
				$idVideo = trim($idVideo);
				if(strlen($idVideo)>0){
					$timeVideo = trim($timeVideo);
					if(strlen($timeVideo)>0){
						$timeVideo = preg_match('/^([0-9]+)$/su',$timeVideo)?"{$timeVideo}s":$timeVideo;
						$idVideo = "{$idVideo}?t={$timeVideo}";
					}
					$text = str_replace($link,'[[YouTube:'.$idVideo.']]',$text);
				} else {
					$text = str_replace($link,'https://www.youtube.com',$text);
				}
				$text = $this->parseYoutubeID($text);
			}
			if(
				preg_match('/^(.*?)(https|http)\:\/\/(m\.youtu|www\.youtu|youtu)\.be\/(.*?)$/su',$text)
			){
				$idVideo = '';
				$timeVideo = '';
				$link = preg_replace('/(.*?)(https|http)\:\/\/(m\.youtu|www\.youtu|youtu)\.be\/(.*?)(\s(.*?)$|$)/su','$2://$3.be/$4',$text);
				$linkParts = explode('#',$link)[0];
				$linkParts = explode('/',$linkParts);
				$linkParts = end($linkParts);
				$linkParts = str_replace('?','&',$linkParts);
				$linkParts = explode('&',$linkParts);
				foreach ($linkParts as $linkPart) {
					$linkPart = explode('=',$linkPart);
					if(count($linkPart)>1){
						if($linkPart[0]=='v'&&strlen($linkPart[1])>0&&strlen(trim($idVideo))<1){
							$idVideo = $linkPart[1];
						}
						if($linkPart[0]=='t'&&strlen($linkPart[1])>0){
							$timeVideo = $linkPart[1];
						}
					} elseif(count($linkPart)==1) {
						$idVideo = $linkPart[0];
					}
				}
				$idVideo = trim($idVideo);
				if(strlen($idVideo)>0){
					$timeVideo = trim($timeVideo);
					if(strlen($timeVideo)>0){
						$timeVideo = preg_match('/^([0-9]+)$/su',$timeVideo)?"{$timeVideo}s":$timeVideo;
						$idVideo = "{$idVideo}?t={$timeVideo}";
					}
					$text = str_replace($link,"[[YouTube:{$idVideo}]]",$text);
				} else {
					$text = str_replace($link,'https://www.youtube.com',$text);
				}
				$text = $this->parseYoutubeID($text);
			}
			return $text;
		}
		public function parseYoutubeShortCode(string $text = '') : string {
			if(
				preg_match('/^(.*?)\[\[YouTube:(.*?)\]\](.*?)$/su',$text)
			){
				$idVideo = preg_replace('/^(.*?)\[\[YouTube:(.*?)\]\](.*?)$/su','$2',$text);
				$youtubeURL = "https://www.youtube.com/watch?v={$idVideo}";
				$videoData = $this->getVideoMetaData($idVideo);
				$videoTitle = isset($videoData['title'])&&strlen(trim($videoData['title']))>0?$videoData['title']:'YouTube video';
				$videoTitle = preg_replace('/\s+/su',' ', $videoTitle);
				$videoTitle = preg_replace('/(^\s|\s$)/su','',$videoTitle);
				$videoImage = $this->getVideoThumbnail($idVideo);
				var_dump($videoImage); die();
				$idVideoEmbed = preg_match('/(.*?)\?t=(.*?)/su',$idVideo)?$idVideo.'&':$idVideo.'?';
				$text = str_replace("[[YouTube:{$idVideo}]]","
					<div>
						<a href=\"#\" onclick=\"document.getElementById('youtube_player_{$idVideo}').style.display='block';\">{$videoTitle}</a>
					</div>
					<div class=\"youtube_player\" id=\"youtube_player_{$idVideo}\" style=\"display:none;\">
						<iframe src=\"https://www.youtube.com/embed/{$idVideoEmbed}rel=0controls=1&showinfo=0\" frameborder=\"0\" allowfullscreen=\"\"></iframe>
					</div>", $text);
				$text = $this->parseYoutubeShortCode($text);
				$text = $this->parseYoutubeID($text);
			}
			return $text;
		}
		public function getVideoMetaData(string $idVideo = '') : array {
			$idVideo = explode('#',$idVideo)[0];
			$idVideo = explode('&',$idVideo)[0];
			$idVideo = explode('?',$idVideo)[0];
			if(is_file(getcwd()."/../protected/common/lib/media/youtube/cache/_{$idVideo}.dat")){
				$content = file_get_contents(getcwd()."/../protected/common/lib/media/youtube/cache/_{$idVideo}.dat");
			} else {
				$content = file_get_contents("https://www.youtube.com/get_video_info?video_id={$idVideo}");
				file_put_contents(getcwd()."/../protected/common/lib/media/youtube/cache/_{$idVideo}.dat",$content);
			}
			parse_str($content, $content);
			return $content;
		}
		public function getVideoThumbnail(string $idVideo = '') : string {
			$idVideo = explode('#',$idVideo)[0];
			$idVideo = explode('&',$idVideo)[0];
			$idVideo = explode('?',$idVideo)[0];
			if(is_file(getcwd()."/../protected/common/lib/media/youtube/res/img/{$idVideo}.jpg")){
				return getcwd()."/../protected/common/lib/media/youtube/res/img/{$idVideo}.jpg";
			}
			$content = file_get_contents("https://img.youtube.com/vi/{$idVideo}/maxresdefault.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/sddefault.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/hqdefault.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/mqdefault.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/default.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/0.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/1.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/2.jpg");
			$content = $content!=false?$content:file_get_contents("https://img.youtube.com/vi/{$idVideo}/3.jpg");
			if($content!=false){
				file_put_contents(getcwd()."/../protected/common/lib/media/youtube/res/img/{$idVideo}.jpg",$content);
				return getcwd()."/../protected/common/lib/media/youtube/res/img/{$idVideo}.jpg";
			} else {
				return '';
			}
		}
	}
?>