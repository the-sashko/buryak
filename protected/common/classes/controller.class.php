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

			/* Get some data for templates */

			$this->initModel('section');
			$this->commonData['sections'] = (new Section)->list();
			$this->commonData['isMainPage'] = false;
			$this->commonData['URLPath'] = [];
			$this->commonData['pageTitle'] = '';
			if(isset($_SESSION['flash_data'])&&is_array($_SESSION['flash_data'])&&count($_SESSION['flash_data'])>0){
				foreach ($_SESSION['flash_data'] as $flashDataIDX => $flashDataVal) {
					$this->commonData[$flashDataIDX] = $flashDataVal;
				}
			}
			$_SESSION['flash_data'] = [];
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
		public function initModel(string $modelName = '') : void {
			$modelName = mb_convert_case($modelName,MB_CASE_TITLE);
			include_once(getcwd()."/../protected/models/{$modelName}.php");
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
		public function returnJSON(bool $status = true, array $data = []) : void {
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