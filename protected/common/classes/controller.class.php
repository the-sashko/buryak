<?php

	/* base class for all controllers */

	abstract class ControllerCore {

		/* including trates for render templates and secururity operations (escaping input, make hashes, etc) */

		use Templater;
		use Security;

		public $post = []; // data from $_POST array
		public $get = []; // data from $_GET array
		public $commonData = []; // common data, that can be used in templates
		public $configData = []; // data from config files
		public $templateScope = 'board'; // default template
		public $pageCache = false; // define caching whole html output of page (by default must be false)

		/*
			default action for calling controller without action
		*/
		abstract public function default() : void;

		public function __construct(array $postData = [], array $getData = []){
			session_start();

			/* Load input post/get data */

			$this->post = array_map([$this,'escapeInput'],$postData);
			$this->get = array_map([$this,'escapeInput'],$getData);
			
			/* Load data from main and security configs */

			$this->initConfig('main');
			$this->initConfig('security');
		}

		/*
			function for including data from JSON config file
		*/
		protected function initConfig(string $configName = '') : void {
			$configName = mb_convert_case($configName,MB_CASE_LOWER);
			$configJSON = file_get_contents(getcwd()."/../protected/config/{$configName}.json");
			$configData = json_decode($configJSON,true);
			$this->configData[$configName] = $configData;
		}

		/*
			function for including class and make instance of model
		*/
		public function initModel(string $modelName = '') : object{
			$modelName = mb_convert_case($modelName,MB_CASE_TITLE);
			include_once(getcwd()."/../protected/models/{$modelName}.php");
			return (new $modelName);
		}

		/*
			function for redirecting
			$URL - redirecting path
			$code - http code
		*/
		public function redirect(string $URL = '', int $code = 302) : void {
			$URL = strlen($URL)>0?$URL:'/'; // make redirecting path valid
			$code = $code>=300&&$code<=308?$code:302; // make http code valid
			header("Location: {$URL}",true,$code);
			die();
		}

		/*
			Function for return JSON data to XHR requests
			$status - is general status of executing XHR request (true - success, false - error)
			$data - some data that is result of executing XHR request
		*/
		public function returnJSON(boll $status = true, array $data = []) : void {
			$dataJSON = [
				'status' => $status,
				'data' => $data
			];
			$dataJSON = json_encode($dataJSON);
			header('Content-Type: application/json');
			echo $dataJSON;
			die();
		}
	}
?>