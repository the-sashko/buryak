<?php
class TelegramSender {
	public function sendMessage(string $message = '', array $chatIDList = [], string $token = '') : bool {
		$message = urlencode($message);
		$res = false;
		foreach ($chatIDList as $chatID) {
			$URL = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatID}";
			$URL = "{$URL}&text={$message}";
			$curl = curl_init();
			$curlParams = [
				CURLOPT_URL => $URL,
				CURLOPT_RETURNTRANSFER => true
			];
			curl_setopt_array($curl, $curlParams);
			$res = curl_exec($curl)||$res;
			curl_close($curl);
		}
		return $res;
	}
}
?>