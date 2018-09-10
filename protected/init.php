<?php

	/* seting encoding and timezone if it not set on web-server config */

	ini_set('default_charset', 'utf-8');
	date_default_timezone_set('Europe/Kiev'); 

	redirect(); // redirecting by some rules, for SEO and secirity reasons

	rewrite(); // rewriting URL, can be replaced by web-server config

	/* parsing URL */

	/*
		Format URL is: /<controller>/<action>/<parameter(s)>/
	*/

	$URIPath = $_SERVER['REQUEST_URI'];
	
	/* redirecting form URL that have wrong format (less than 3 sections) */

	if(
		!preg_match('/^\/(.*?)\/(.*?)\/(.*?)\/$/su', $URIPath) &&
		!preg_match('/^\/(.*?)\/(.*?)\/$/su', $URIPath)
	){
		header('Location: /');
		die();
	}

	$URIPath = preg_replace('/^\/(.*?)\/$/su','$1',$URIPath);
	$URIPath = explode('/',$URIPath);

	/* redirecting form URL that have wrong format (more than 3 sections) */

	if(count($URIPath)>3){
		header('Location: /error/404/',true,301);
		die();
	}

	$controller = $URIPath[0];
	$action = $URIPath[1];
	$param = isset($URIPath[2])?$URIPath[2]:NULL;

	/* check format name of controller/action and parameter(s) */

	/*
		Controller and action names - only 1 or more low-case latin characters
		Parameter(s) - emprty string or NULL value or only low-case latin character, digits, undercore and "-" sign, also can't starting or ending from non-latin and non-digital charaters
	*/
	if(
		!preg_match('/^([a-z]+)$/su',$controller) ||
		!preg_match('/^([a-z]+)$/su',$action) ||
		(
			$param != NULL &&
			!preg_match('/^([a-zA-Z0-9\-\_]+)$/su',$param) &&
			!preg_match('/^([\-\_]+)(.*?)([\-\_]+)$/su',$param)
		) ||
		!strlen($action)>0 ||
		!strlen($controller)>0
	){
		header('Location: /error/404/',true,301);
		die();
	}

	/*
		format parameter(s), controller and action names
		Controller - <controller name (low-case with title-case first letter)>Controller
		action - action<action name (low-case with title-case first letter)>
		parameter(s) (if empty) - NULL
		parameter (if single) - string (equal third URL section)
		parameters (is multiple) - 1 array of strings: emploded string (equal third URL section) by undercore characters
	*/

	$controller = mb_convert_case($controller,MB_CASE_TITLE);
	$controller = "{$controller}Controller";
	$controller = $controller!='ApiController'?$controller:'APIController';//fix controller name for API
	$controller = $controller!='AjaxController'?$controller:'AJAXController';//fix controller name for Ajax
	$action = strlen($action)>0&&$action!='default'?'action'.mb_convert_case($action,MB_CASE_TITLE):'default';
	if(
		$param != NULL &&
		preg_match('/^(.*?)\_(.*?)$/su', $param)
	) {
		$param = explode('_',$param);
	}
	unset($URIPath);
	if(is_file(getcwd()."/../protected/controllers/{$controller}.php")){ // if Controller file is exist
		require_once(getcwd().'/../protected/common/lib/init.php'); // include all libraries
		require_once(getcwd().'/../protected/common/classes/controller.class.php'); // include base class for all controllers
		require_once(getcwd().'/../protected/common/classes/model.class.php'); // include base class for all models
		require_once(getcwd()."/../protected/controllers/{$controller}.php"); // include base class for controller
		if(class_exists($controller)){ // if Controller class loaded
			$controller = new $controller($_POST,$_GET); // create instance of controller class with sending input post/get parameters

			/*
				Clearing input post/get parameters for security reasons.
				For get input data use $this->post or $this->get construction into controllers
			*/

			$_POST = [];
			$_GET = [];

			if(method_exists($controller,$action)){ // if action exist 
				$reflection = new ReflectionMethod($controller, $action);
				if($reflection->isPublic()){ // if action callable (public)
					if($param!=NULL){ // if input parameter(s) from URL exists
						if(count($reflection->getParameters())==1){ // if action have 1 input parameter
							unset($reflection);
							$controller->$action($param); // call action with parameter(s)
						} else {
							header('Location: /error/404/');
							die();
						}
					} else {// if input parameter(s) from URL not exists
						unset($reflection);
						unset($param);
						$controller->$action();  // call action without parameter(s)
					}
				} else {
					header('Location: /error/404/');
					die();
				}
			} else {
				header('Location: /error/404/');
				die();
			}
		} else {
			header('Location: /error/404/');
			die();
		}
	} else {
		header('Location: /error/404/');
		die();
	}

	function redirect(){

		/* removing GET params */

		$uri = explode('#',$_SERVER['REQUEST_URI'])[0]; /* regular browsers not send part URL after '#' but for security reasons replacing it */
		$uri = explode('&',$uri)[0];
		$uri = explode('?',$uri)[0];

		/* redirecting from URL, that contain double slashes or double undercores or double "-" sign or haven't slash at the end of line */

		if(
			(
				!preg_match('/^\/(.*?)\/$/su',$uri) &&
				$uri!='/' &&
				$uri!=''
			) ||
			preg_match('/^(.*?)\/\/(.*?)$/su',$uri) ||
			preg_match('/^(.*?)\_\_(.*?)$/su',$uri) ||
			preg_match('/^(.*?)\-\-(.*?)$/su',$uri)
		){
			$uri = "/{$uri}/";
			$uri = preg_replace('/([\/]+)/su','/',$uri);
			header("Location: {$uri}",true,301);
			die();
		}

		/*
			redirecting from URL, that contain front-office controller names and word "default" (for SEO reasons)
			or
			redirecting from URL, that contain undercore, because it used for delimeter multiple input params (after rewrite URL)
		*/

		if(
			preg_match('/^\/main\/(.*?)$/su',$uri) ||
			preg_match('/^\/section\/(.*?)$/su',$uri) ||
			preg_match('/^\/default\/(.*?)$/su',$uri) ||
			preg_match('/^\/post\/(.*?)$/su',$uri) ||
			preg_match('/^(.*?)_(.*?)$/su',$uri)
		){
			header("Location: /",true,301);
			die();
		}

		/*
			redirecting from URL, that explicity contain first page in pagination (for SEO reasons)
			or
			redirecting from URL, that explicity contain zero page in pagination (for SEO reasons)
			or
			redirecting from URL, that explicity contain leading zero page in pagination (for SEO reasons)
		*/

		if(
			preg_match('/^(.*?)\/page\-1\/$/su',$uri) ||
			preg_match('/^(.*?)\/page\-([0]+)(.*?)\/$/su',$uri)
		){
			$uri = preg_replace('/\/page\-([0-9]+)\//su','/',$uri);
			header("Location: {$uri}",true,301);
			die();
		}

		/*
			redirecting from index page admin-panel (for admin-users)
		*/

		if(
			preg_match('/^\/admin\/$/su',$uri)
		){
			header("Location: /admin/posts/",true,301);
			die();
		}
		/*
			redirecting from index page admin-panel (for moderators)
		*/

		if(
			preg_match('/^\/mod\/$/su',$uri)
		){
			header("Location: /mod/posts/",true,301);
			die();
		}

	}
	function rewrite(){

		/* removing GET params */

		$_SERVER['REQUEST_URI'] = explode('#',$_SERVER['REQUEST_URI'])[0]; // regular browsers not send part URL after '#' but for security reasons replacing it
		$_SERVER['REQUEST_URI'] = explode('&',$_SERVER['REQUEST_URI'])[0];
		$_SERVER['REQUEST_URI'] = explode('?',$_SERVER['REQUEST_URI'])[0];

		$_SERVER['REQUEST_URI'] = strlen($_SERVER['REQUEST_URI'])>0?$_SERVER['REQUEST_URI']:'/';  // regular browsers not send empty URL but for security reasons replacing it

		/* rewriting for API */
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/posts\/$/su','/api/posts/$1_all_0_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/posts\/([a-z]+)\/$/su','/api/posts/$1_$2_0_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/posts\/([a-z]+)\/([0-9]+)\/$/su','/api/posts/$1_$2_$3_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/posts\/([a-z]+)\/([0-9]+)\/page-([0-9]+)\/$/su','/api/posts/$1_$2_$3_$4',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/post\/([0-9]+)\/$/su','/api/post/$1_$2',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/threads\/$/su','/api/posts/$1_all_0_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/threads\/([a-z]+)\/$/su','/api/posts/$1_$2_0_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/threads\/([a-z]+)\/([0-9]+)\/$/su','/api/posts/$1_$2_$3_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/threads\/([a-z]+)\/([0-9]+)\/page-([0-9]+)\/$/su','/api/posts/$1_$2_$3_$4',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/thread\/([0-9]+)\/$/su','/api/post/$1_$2',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/sections\/$/su','/api/sections/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/write\/([a-z]+)\/$/su','/api/posts/$1_$2_0_1',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/api\/(.*?)\/pages\/([a-z]+)\/$/su','/api/posts/$1_$2_0_1',$_SERVER['REQUEST_URI']);

		/* rewriting for back-office */

		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/login\/$/su','/admin/login/admin/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/logout\/$/su','/admin/logout/admin/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/login\/restore\/$/su','/admin/restore/admin/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/login\/set\/$/su','/admin/setpassword/admin/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/section\/([a-z]+)\/$/su','/admin/editsection/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/user\/([0-9]+)\/$/su','/admin/edituser/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/posts\/$/su','/admin/posts/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/posts\/page-([0-9]+)\/$/su','/admin/posts/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/post\/([0-9]+)\/$/su','/admin/editpost/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/ban\/$/su','/admin/ban/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/ban\/page-([0-9]+)\/$/su','/admin/ban/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/ban\/([0-9]+)\/$/su','/admin/editban/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/inbox\/$/su','/admin/inbox/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/inbox\/([0-9]+)\/$/su','/admin/inbox/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/admin\/inbox\/([0-9]+)\/$/su','/admin/messages/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/login\/$/su','/admin/login/mod/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/logout\/$/su','/admin/logout/mod/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/login\/restore\/$/su','/admin/restore/mod/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/login\/set\/$/su','/admin/setpassword/mod/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/posts\/$/su','/admin/posts/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/posts\/page-([0-9]+)\/$/su','/admin/posts/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/post\/([0-9]+)\/$/su','/admin/editpost/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/inbox\/$/su','/admin/inbox/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/inbox\/([0-9]+)\/$/su','/admin/inbox/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/mod\/inbox\/([0-9]+)\/$/su','/admin/messages/$1/',$_SERVER['REQUEST_URI']);

		/* rewriting for front-office */

		$_SERVER['REQUEST_URI'] = preg_replace('/^\/$/su','/main/allposts/1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/page\-([0-9]+)\/$/su','/main/allposts/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/page\/([a-z0-9-]+)\/$/su','/main/page/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/options\/$/su','/main/options/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/ban\/$/su','/main/ban/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/write\/$/su','/post/write/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/error\/([0-9]+)\/$/su','/main/error/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/remove\/([0-9]+)\/$/su','/post/remove/$1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/([a-z]+)\/$/su','/section/list/$1_1/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/([a-z]+)\/page\-([0-9]+)\/$/su','/section/list/$1_$2/',$_SERVER['REQUEST_URI']);
		$_SERVER['REQUEST_URI'] = preg_replace('/^\/([a-z]+)\/([0-9]+)\/$/su','/section/thread/$1_$2/',$_SERVER['REQUEST_URI']);
	}
?>