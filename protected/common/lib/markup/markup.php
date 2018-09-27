<?php
	/*
		List of shortcodes:
			[s]Text[/s] - striked text
			[b]Text[/b] - bold text
			[i]Text[/i] - italic text
			[spoiler]Text[/spoiler] - hidden text
			[u]Text[/u] - text with underline
			[q]Text[/q] - Quote
			=== Internal shortcodes (used by other libs) ===
			[Reply:<ID of post>] - Link to other post
			[YouTube:<ID of video>] - YouTube player
			[Link:<URL>:"<Title>"] - Link
		Alternative synax:
			DELTextDEL equal [s]Text[/s]
			~~Text~~ equal [s]Text[/s]
			*Text* equal [b]Text[/b]
			**Text** equal [b]Text[/b]
			>Text equal [q]Text[/q]
			>><ID of post> equal [Reply:<ID of post>]
	*/
	trait Markup{
		public function normalizeSyntax(string $text = '') : string {
			$text = str_replace('&gt;','>',$text);
			$text = preg_replace('/~~(.*?)~~/su','[s]$1[/s]',$text);
			$text = preg_replace('/DEL(.*?)DEL/su','[s]$1[/s]',$text);
			$text = preg_replace('/\*\*(.*?)\*\*/su','[b]$1[/b]',$text);
			$text = preg_replace('/\*(.*?)\*/su','[i]$1[/i]',$text);
			$text = preg_replace('/\%\%(.*?)\%\%/su','[spoiler]$1[/spoiler]',$text);
			$text = preg_replace('/\%\%(.*?)\%\%/su','[spoiler]$1[/spoiler]',$text);
			$text = preg_replace('/\>\>([0-9]+)/su',"[Reply:$1]",$text);
			$text = preg_replace('/\>(.*?)\n/su',"\n[q]$1[/q]\n",$text);
			$text = preg_replace('/\>(.*?)$/su',"\n[q]$1[/q]",$text);
			$text = preg_replace('/\[q\]/su',"[q]&gt;",$text);
			$text = preg_replace('/\[q\]\&gt\;([\s]+)/su',"[q]&gt;",$text);
			$text = preg_replace('/\[\/q\]([\s]+)\[q\]/su',"\n",$text);
			$text = preg_replace('/([\s]+)\[q\]/su',"\n[q]",$text);
			$text = preg_replace('/([\s]+)\[\/q\]/su',"[/q]\n",$text);
			$text = preg_replace('/\[\/q\]([\s]+)/su',"[/q]\n",$text);
			$text = str_replace('>','&gt;',$text);
			return $text;
		}
		public function markup2HTML(string $text = '') : string {
			$text = preg_replace('/\[s\](.*?)\[\/s\]/su','<strike>$1</strike>',$text);
			$text = preg_replace('/\[b\](.*?)\[\/b\]/su','<strong>$1</strong>',$text);
			$text = preg_replace('/\[i\](.*?)\[\/i\]/su','<i>$1</i>',$text);
			$text = preg_replace('/\[spoiler\](.*?)\[\/spoiler\]/su','<span class="spoiler">$1</span>',$text);
			$text = preg_replace('/\[u\](.*?)\[\/u\]/su','<span class="utag">$1</span>',$text);
			$text = preg_replace('/([\s]+)\[q\]/su','[q]',$text);
			$text = preg_replace('/\[q\]([\s]+)/su','[q]',$text);
			$text = preg_replace('/([\s]+)\[\/q\]/su','[/q]',$text);
			$text = preg_replace('/\[\/q\]([\s]+)/su','[/q]',$text);
			$text = preg_replace('/\[q\]/su','[q]<p>',$text);
			$text = preg_replace('/\[\/q\]/su','</p>[/q]',$text);
			$text = preg_replace('/\[q\](.*?)\[\/q\]/su','<blockquote>$1</blockquote>',$text);
			$text = preg_replace('/\n+/su','</p><p>',$text);
			$text = "{$text}";
			return $text;
		}
		public function normalizeText(string $text = '') : string {
			$text = preg_replace('/\n+/su',"<br>",$text);
			$text = preg_replace('/\s+/su',' ',$text);
			$text = preg_replace('/\<br\>\s/su','<br>',$text);
			$text = preg_replace('/\s\<br\>/su','<br>',$text);
			$text = preg_replace('/(^\s|\s$)/su','',$text);
			$text = preg_replace('/(^\<br\>|\<br\>$)/su','',$text);
			$text = preg_replace('/\<br\>/su',"\n",$text);
			$text = preg_replace('/\n+/su',"\n",$text);
			return $text;
		}
	}
?>