<?php
	trait Share {
		public $twitterKeys = [];
		public $telegramKeys = [];
		public function initShare() : void {
			require_once(getcwd().'/../protected/common/lib/share/credentials.php');
			$this->twitterKeys = $twitterKeys;
			$this->telegramKeys = $telegramKeys;
		}
		public function send2twitter(string $message = '') : bool {
			\Codebird\Codebird::setConsumerKey(
				$this->twitterKeys['consumerKey'],
				$this->twitterKeys['consumerSecret']
			);
			$codeBird = \Codebird\Codebird::getInstance();
			$codeBird->setToken(
				$this->twitterKeys['accessToken'],
				$this->twitterKeys['accessTokenSecret']
			);
			$params = [
				'status' => $message
			];
			$reply = $codeBird->statuses_update($params);
			return !isset($reply->errors);
		}
		public function send2telegram(string $message = '') : bool {
			return (new TelegramSender)->sendMessage($message,$this->telegramKeys['chatIDList'],$this->telegramKeys['keyAPI']);
		}
		public function share(string $message = '', string $type = '') : bool {
			switch ($type) {
				case 'twitter':
					return $this->send2twitter($message);
					break;				
				case 'telegram':
					return $this->send2telegram($message);
					break;
				default:
					return false;
					break;
			}
		}
	}
?>