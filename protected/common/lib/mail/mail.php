<?php

	/*
		Trait for sending emails
	*/
	trait Mail {

		/*
			function for sending emails
			$email - receiver email address
			$message - text of message
			$subjenct - title of message
			$replyEmail - email address for reply
		*/
		public function sendMail(string $email = '', string $message = '', string $subject = '', string $replyEmail = '') : void {
			
			/*
				if email and message set - sending
			*/

			if(preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$email)>0&&strlen($message)>0){
				$subject = !strlen($subject)>0?'Subject not set':$subject; //set fake subject if it not set

				/*
					if $replyEmail not set or have bad format - get it from main config (if it exist) or set fake address
				*/

				if(
					!preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$replyEmail) &&
					isset($this->configData) &&
					is_array($this->configData) &&
					isset($this->configData['main'])>0 &&
					is_array($this->configData['main'])>0 &&
					preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$this->configData['main']['email'])
				){
					$replyEmail = $this->configData['main']['email'];
				}
				$replyEmail = preg_match('/^(.*?)@(.*?)\.(.*?)$/su',$replyEmail)?$replyEmail:'noreply@noreply.noreply';

				/*
					setting mail headers and send email
				*/

				$emailHeaders = "From: {$replyEmail}\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\nX-Mailer: PHP/".phpversion();
				mail($email, $subject, $message, $emailHeaders);
			}
		}
	}
?>