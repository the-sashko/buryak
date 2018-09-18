<?php
	trait GeoIP {
		public function getGeodata($ip = '0.0.0.0') : string {
			$APIKey = $this->configData['security']['geo_api_key'];
			$sql = "
				SELECT
					`country` AS 'country'
				FROM `geoip`
				WHERE `ip` = '{$ip}';
			";
			$res = $this->select($sql,'geoip');
			if(count($res)>0&&is_array($res[0])&&isset($res[0]['country'])&&strlen($res[0]['country'])>0){
				return $res[0]['country'];
			} else {
				$url = "http://api.ipstack.com/{$ip}?access_key={$APIKey}&format=1";
				$res = file_get_contents($url);
				var_dump($res);
				die();
			}
		}
	}
?>