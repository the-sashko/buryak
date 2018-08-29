<?php

	/*
		Trait for working with database 
	*/

	trait DB {

		/* connect to database with data form config file */

		public function DBConnect() : object {

			/*
				Read data from config file
			*/

			$configJSON = file_get_contents(getcwd().'/../protected/config/db.json');
			$config = json_decode($configJSON);

			/*
				set host, db and modes for working with PDO driver
			*/

			$connectionDataString = 'mysql:host='.$config->host.';dbname='.$config->db.';charset=utf8';
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			];
			
			try{

				/*
					creating new PDO instace an return it
				*/

				$pdo = new PDO($connectionDataString,$config->user,$config->pass, $options);
				return $pdo;
			} catch (PDOException $error){ // If arror - send 500 code and display error message with debug info
				http_response_code(500);
				$error = "Could not connect to database!\n<!--\n{$error}\n-->\n";
				die($error);
			}
		}

		/* only for SELECT queries */

		public function select(string $sql = '', string $scope = 'default', int $ttl = 60*60*24*30*6) : array {
			/*
				$sql - SQL query
				$scope - name of scope (for improving cachnig)
				$ttl - time to live for cache in seconds (0 - for disable or ignore)
			*/

			if($ttl>0){ // if caching enabled
				$scope = $scope != '' ? $scope : 'default'; // make query scope valid
				$queryCacheFile = getcwd().'/../protected/res/cache/db/'.$scope.'/'.hash('md5',$sql).hash('sha512',$sql).hash('md5',$scope.$sql); // make name of cache file form 3 differnt hashes (for improving protection form collision)
				
				/*
					check and verify cache
				*/

				if(is_file($queryCacheFile)){ // is cahe exist
					$queryData = file_get_contents($queryCacheFile);
					$queryData = json_decode($queryData,true);
					if(
						isset($queryData['time']) &&
						intval($queryData['time']) > time() &&
						isset($queryData['content'])
					){ // if cache is fresh and contain data
						return json_decode(base64_decode($queryData['content']),true); // return cached data
					} else {
						unlink($queryCacheFile); // remove cahed file
					}
				}
			}
			$pdo = $this->DBConnect(); //connecting to DB
			if($pdo === 0){ // if PDO object empty - return empty data
				$pdo = NULL;
				return [];
			} else {
				try{

					/*
						Executing SQL
					*/

					$result = $pdo->query($sql); // executing SQL
					$pdo = NULL;
					$result = (array)$result->fetchALL(); // fetching data and converting all types (for example NULL) to array

					if($ttl>0){ // if cache enabled - save results into cache
						$queryData = [
							'time' => time()+$ttl,
							'content' => base64_encode(json_encode($result))
						];
						if(is_file($queryCacheFile)){
							unlink($queryCacheFile);
						}
						if(!is_dir(getcwd().'/../protected/res/cache/db/'.$scope)){
							mkdir(getcwd().'/../protected/res/cache/db/'.$scope);
							chmod(getcwd().'/../protected/res/cache/db/'.$scope, 0775);
						}
						file_put_contents($queryCacheFile, json_encode($queryData));
						chmod($queryCacheFile, 0775);
					}
					return $result; // returning results
				} catch (PDOException $error){ // if error - display error message with debug info
					http_response_code(500);
					$error = "SQL query failed!\n<!--\n\"{$error->getMessage()}\" Query: \"{$sql}\"\n-->\n";
					die($error);
				}
			}
		}

		/* for all queries except SELECT */

		public function query(string $sql = '', string $scope = 'default') : bool {

			/*
				$sql - SQL query
				$scope - name of scope (for improving cachnig)
			*/
			
			$scope = $scope != '' ? $scope : 'default'; // make query scope valid

			$pdo = $this->DBConnect(); //connecting to DB

			if($pdo === 0){ // if PDO object empty - return empty data
				$pdo = NULL;
				return false;
			} else {
				try{
					$result = (bool)$pdo->query($sql); // executing SQL query and converting all types (for example NULL) to boolean
					$pdo = NULL;

					/*
						clear all cache by scope
					*/

					if(is_dir(getcwd().'/../protected/res/cache/db/'.$scope.'/')){
						foreach(scandir(getcwd().'/../protected/res/cache/db/'.$scope.'/') as $fileItem){
							if(
								$fileItem!='.' &&
								$fileItem!='..' &&
								is_file(getcwd().'/../protected/res/cache/db/'.$scope.'/'.$fileItem)
							){
								unlink(getcwd().'/../protected/res/cache/db/'.$scope.'/'.$fileItem);
							}
						}
					}

					return $result; // return result of execution query
				} catch (PDOException $error){ // if error - display error message with debug info
					http_response_code(500);
					$error = "SQL query failed!\n<!--\n\"{$error->getMessage()}\" Query: \"{$sql}\"\n-->\n";
					die($error);
				}
			}
		}
	}
?>