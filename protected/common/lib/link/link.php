<?php
	trait Link {
		function parseLink(string $text = '') : string {
			$text = preg_replace_callback("/(https|http)\:\/\/(.*?)(\s|$)/su",[$this,'makeLinkShortCode'],$text);
			return $text;
		}
		function parseLinkShortCode(string $text = '') : string {
			$text = preg_replace('/\[Link\:(.*?)\:\"(.*?)\"\]/su','<a href="$1" target="_blank" rel="nofollow">$2</a>',$text);
			return $text;
		}
		function getWebPageMetaData(string $URL = '') : array {
			$URLHash = hash('sha512',$URL).'_'.hash('md5',$URL);
			if(is_file(getcwd()."/../protected/common/lib/link/cache/_{$URLHash}.dat")){
				$metaDataJSON = file_get_contents(getcwd()."/../protected/common/lib/link/cache/_{$URLHash}.dat");
				$metaData = json_decode($metaDataJSON,true);
				$metaData['URL'] = isset($metaData['URL'])?base64_decode($metaData['URL']):'#';
				$metaData['title'] = isset($metaData['title'])?$metaData['title']:'&nbsp;';
				$metaData['description'] = isset($metaData['description'])?$metaData['description']:'&nbsp;';
				$metaData['image'] = isset($metaData['image'])?$metaData['image']:'/assets/img/website.png';
			} else {
				$baseURL = preg_replace('/^(http|https)\:\/\/(.*?)(\/(.*?)$|$)/su','$1://$2',$URL);
				$baseURL = explode('#',$URL)[0];
				$baseURL = explode('&',$URL)[0];
				$baseURL = explode('?',$URL)[0];
				$domain = explode('//',$baseURL);
				$domain = isset($domain[1])?$domain[1]:$baseURL;
				$title = '';
				$description = '';
				$image = '';
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_COOKIESESSION, true);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($curl, CURLOPT_URL, $URL);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$pageHTML = curl_exec($curl);
				curl_close($curl);
				$pageHTML = (string)mb_convert_encoding($pageHTML,'UTF-8');
				$pageHTML = htmlspecialchars_decode($pageHTML);
				$pageHTML = preg_replace('/\<script(.*?)\>(.*?)\<\/script\>/su','',$pageHTML);
				$pageHTML = preg_replace('/\<script(.*?)\>/su','',$pageHTML);
				$pageHTML = preg_replace('/\<noscript(.*?)\>(.*?)\<\/noscript\>/su','',$pageHTML);
				$pageHTML = preg_replace('/\<noscript(.*?)\>/su','',$pageHTML);
				$pageHTML = preg_replace('/\<style(.*?)\>(.*?)\<\/style\>/su','',$pageHTML);
				$pageHTML = preg_replace('/\<style(.*?)\>/su','',$pageHTML);
				if(preg_match('/^(.*?)\<meta([\s]+)property=(\"|\')og\:title(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<meta([\s]+)property=(\"|\')og\:title(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:title(\"|\')(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:title(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:title(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:title(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:title(\"|\')(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:title(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<title([\s]+|)\>(.*?)\<\/title\>(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<title([\s]+|)\>(.*?)\<\/title\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<h1(.*?)\>(.*?)\<\/h1\>(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<h1(.*?)\>(.*?)\<\/h1\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<h1(.*?)\>(.*?)\<\/h1\>(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<h1(.*?)\>(.*?)\<\/h1\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<main(.*?)\>(.*?)\<\/main\>(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<main(.*?)\>(.*?)\<\/main\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($title))<3 && preg_match('/^(.*?)\<body(.*?)\>(.*?)\<\/body\>(.*?)$/su',$pageHTML)){
					$title = preg_replace('/^(.*?)\<body(.*?)\>(.*?)\<\/body\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($title))<3){
					$title = $domain;
					$title = preg_match('/^www\.(.*?)$/su',$title)?preg_replace('/^www\.(.*?)$/su','$1',$title):$title;
				}
				if(preg_match('/^(.*?)\<meta([\s]+)property=(\"|\')og\:description(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)property=(\"|\')og\:description(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:description(\"|\')(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:description(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:description(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:description(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:description(\"|\')(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:description(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<meta([\s]+)name=(\"|\')description(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)name=(\"|\')description(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')description(\"|\')(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')description(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<article(.*?)\>(.*?)\<\/article\>(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<article(.*?)\>(.*?)\<\/article\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<main(.*?)\>(.*?)\<\/main\>(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<main(.*?)\>(.*?)\<\/main\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<p(.*?)\>(.*?)\<\/p\>(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<p(.*?)\>(.*?)\<\/p\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($description))<3 && preg_match('/^(.*?)\<body(.*?)\>(.*?)\<\/body\>(.*?)$/su',$pageHTML)){
					$description = preg_replace('/^(.*?)\<body(.*?)\>(.*?)\<\/body\>(.*?)$/su','$3',$pageHTML);
				}
				if(strlen(trim($description))<3){
					$description = $pageHTML;
				}
				if(preg_match('/^(.*?)\<meta([\s]+)property=(\"|\')og\:image(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<meta([\s]+)property=(\"|\')og\:image(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:image(\"|\')(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)property=(\"|\')og\:image(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:image(\"|\')([\s]+)content=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<meta([\s]+)name=(\"|\')twitter\:image(\"|\')([\s]+)content=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:image(\"|\')(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<meta([\s]+)content=(\"|\')(.*?)\"([\s]+)name=(\"|\')twitter\:image(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<link([\s]+)rel=(\"|\')image_src(\"|\')([\s]+)href=(\"|\')(.*?)\"(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<link([\s]+)rel=(\"|\')image_src(\"|\')([\s]+)href=(\"|\')(.*?)(\"|\')(.*?)$/su','$7',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<link([\s]+)href=(\"|\')(.*?)\"([\s]+)rel=(\"|\')image_src(\"|\')(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<link([\s]+)href=(\"|\')(.*?)\"([\s]+)rel=(\"|\')image_src(\"|\')(.*?)$/su','$4',$pageHTML);
				}
				if(strlen(trim($image))<5 && preg_match('/^(.*?)\<img(.*?)src=(\"|\')(.*?)(\"|\')(.*?)\>(.*?)$/su',$pageHTML)){
					$image = preg_replace('/^(.*?)\<img(.*?)src=(\"|\')(.*?)(\"|\')(.*?)\>(.*?)$/su','$4',$pageHTML);
				}
				$title = strip_tags($title);
				$title = htmlspecialchars_decode($title);
				$title = preg_replace('/\s+/su',' ',$title);
				$title = preg_replace('/(^\s)|(\s$)/su','',$title);
				$title = strlen($title)>128?(string)mb_substr($title,0,128).'[…]':$title;
				$title = htmlspecialchars($title);
				$title = addslashes($title);
				$description = strip_tags($description);
				$description = htmlspecialchars_decode($description);
				$description = preg_replace('/\s+/su',' ',$description);
				$description = preg_replace('/(^\s)|(\s$)/su','',$description);
				$description = strlen($description)>256?(string)mb_substr($description,0,256).'[…]':$description;
				$description = htmlspecialchars($description);
				$description = addslashes($description);
				$image = trim($image);
				if(strlen(trim($image))>=5 && preg_match('/^\/(.*?)$/su',$image)){
					$image = "{$baseURL}/{$image}";
					$image = preg_replace('/([\/]+)/su','/',$image);
					$image = preg_replace('/http\:\//su','http://',$image);
					$image = preg_replace('/https\:\//su','https://',$image);
				}
				$image = strlen($image)>0?$image:'/assets/img/website.png';
				$metaData = [
					'URL' => base64_encode($URL),
					'title' => $title,
					'description' => $description,
					'image' => $image
				];
				$metaDataJSON = json_encode($metaData);
				file_put_contents(getcwd()."/../protected/common/lib/link/cache/_{$URLHash}.dat",$metaDataJSON);
				$metaData['URL'] = base64_decode($metaData['URL']);
			}
			return $metaData;
		}
		function makeLinkShortCode(array $URLParts = []) : string {
			$shortCode = '';
			if(count($URLParts)>0&&strlen($URLParts[0])>0){
				$URL = $URLParts[0];
				$URL = trim($URL);
				if(preg_match('/^(.*?)([^0-9a-z\/_-]+)$/su',$URL)){
					$endLine = preg_replace('/^(.*?)([^0-9a-z\/_-]+)$/su','$2',$URL);
				} else {
					$endLine = '';
				}
				$URL = preg_replace('/([^0-9a-z\/_=\-]+)$/su','',$URL);
				$metaData = $this->getWebPageMetaData($URL);
			}
			$shortCode = " [Link:{$URL}:\"{$metaData['title']}\"] {$endLine} ";
			return $shortCode;
		}
	}
?>